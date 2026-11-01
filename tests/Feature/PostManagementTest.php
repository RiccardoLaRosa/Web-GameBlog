<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed();
        Storage::fake('public');
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->category = Category::first();
    }

    private function jpg(string $name = 'gioco.jpg', int $kilobytes = 100): UploadedFile
    {
        return UploadedFile::fake()->create($name, $kilobytes, 'image/jpeg');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Elden Ring',
            'description' => 'Recensione',
            'category_id' => $this->category->id,
        ], $overrides);
    }

    public function test_admin_can_create_a_post_with_category_tags_and_image(): void
    {
        $tag = Tag::first();

        $this->actingAs($this->admin)
            ->post(route('posts.store'), $this->payload(['image' => $this->jpg(), 'tag' => [$tag->id]]))
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $post = Post::firstOrFail();
        $this->assertSame($this->category->id, $post->category_id);
        $this->assertSame($this->admin->id, $post->user_id);
        $this->assertEquals([$tag->id], $post->tags->pluck('id')->all());
        Storage::disk('public')->assertExists($post->image);

        $this->get(route('posts.index'))->assertOk()->assertSee('Elden Ring');
    }

    public function test_create_rejects_invalid_data(): void
    {
        $this->actingAs($this->admin)
            ->post(route('posts.store'), [
                'image' => UploadedFile::fake()->create('virus.php', 10, 'application/x-php'),
                'tag' => [9999],
                'category_id' => 9999,
            ])
            ->assertSessionHasErrors(['title', 'description', 'image', 'category_id', 'tag.0']);

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_image_over_2mb_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post(route('posts.store'), $this->payload(['image' => $this->jpg('grande.jpg', 2049)]))
            ->assertSessionHasErrors('image');
    }

    public function test_edit_page_shows_current_values_and_tag_labels(): void
    {
        $post = Post::create($this->payload());

        $this->actingAs($this->admin)
            ->get(route('posts.edit', $post))
            ->assertOk()
            ->assertSee('Elden Ring')
            ->assertSee(Tag::first()->message)
            ->assertSee('name="tag[]"', false);
    }

    public function test_update_changes_fields_and_tags_and_replaces_the_image(): void
    {
        $oldImage = $this->jpg('vecchia.jpg')->store('uploads', 'public');
        $post = Post::create($this->payload(['image' => $oldImage]));
        [$oldTag, $newTag] = Tag::take(2)->get();
        $post->tags()->attach($oldTag);
        $newCategory = Category::where('id', '!=', $this->category->id)->first();

        $this->actingAs($this->admin)
            ->put(route('posts.update', $post), [
                'title' => 'Nuovo titolo',
                'description' => 'Nuova descrizione',
                'category_id' => $newCategory->id,
                'tag' => [$newTag->id],
                'image' => $this->jpg('nuova.jpg'),
            ])
            ->assertRedirect(route('posts.show', $post));

        $post->refresh();
        $this->assertSame('Nuovo titolo', $post->title);
        $this->assertSame('Nuova descrizione', $post->description);
        $this->assertSame($newCategory->id, $post->category_id);
        $this->assertEquals([$newTag->id], $post->tags->pluck('id')->all());
        $this->assertNotSame($oldImage, $post->image);
        Storage::disk('public')->assertExists($post->image);
        Storage::disk('public')->assertMissing($oldImage);
    }

    public function test_update_without_a_new_image_keeps_the_current_one(): void
    {
        $image = $this->jpg()->store('uploads', 'public');
        $post = Post::create($this->payload(['image' => $image]));
        $post->tags()->attach(Tag::first());

        $this->actingAs($this->admin)
            ->put(route('posts.update', $post), $this->payload(['title' => 'Altro titolo']))
            ->assertRedirect(route('posts.show', $post));

        $post->refresh();
        $this->assertSame($image, $post->image);
        $this->assertCount(0, $post->tags);
        Storage::disk('public')->assertExists($image);
    }

    public function test_failed_update_keeps_the_old_image(): void
    {
        $image = $this->jpg()->store('uploads', 'public');
        $post = Post::create($this->payload(['image' => $image]));

        $this->actingAs($this->admin)
            ->put(route('posts.update', $post), $this->payload(['image' => $this->jpg('grande.jpg', 2049)]))
            ->assertSessionHasErrors('image');

        $this->assertSame($image, $post->fresh()->image);
        Storage::disk('public')->assertExists($image);
    }

    public function test_destroy_deletes_the_post_and_its_image(): void
    {
        $image = $this->jpg()->store('uploads', 'public');
        $post = Post::create($this->payload(['image' => $image]));

        $this->actingAs($this->admin)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing($image);
    }

    public function test_lists_handle_posts_without_image_or_category(): void
    {
        $post = Post::create(['title' => 'Senza niente', 'description' => 'x']);
        $withCategory = Post::create($this->payload(['title' => 'Senza immagine']));

        $this->get(route('posts.index'))->assertOk()->assertSee('Senza niente')->assertSee('No Image');
        $this->get(route('byCategory', $this->category))->assertOk()->assertSee('No Image');
        $this->get(route('posts.show', $post))->assertOk();
        $this->get(route('posts.show', $withCategory))->assertOk();
    }

    public function test_badges_match_the_seeded_tags(): void
    {
        $post = Post::create($this->payload());
        $post->tags()->attach(Tag::where('message', 'DLC')->first());

        $this->get(route('posts.index'))->assertOk()->assertSee('DLC')->assertDontSee('Popolare');
    }
}
