<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\PostSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function makePost(): Post
    {
        return Post::create([
            'title' => 'Titolo',
            'description' => 'Descrizione',
            'category_id' => Category::first()->id,
        ]);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function protectedRoutes(): array
    {
        return [
            'create' => ['get', '/posts/create'],
            'store' => ['post', '/posts'],
            'edit' => ['get', '/posts/{post}/edit'],
            'update' => ['put', '/posts/{post}'],
            'destroy' => ['delete', '/posts/{post}'],
            'subscribers' => ['get', '/admin/iscritti'],
            'destroy subscriber' => ['delete', '/admin/iscritti/{subscriber}'],
        ];
    }

    #[DataProvider('protectedRoutes')]
    public function test_reader_gets_403(string $method, string $uri): void
    {
        $post = $this->makePost();
        $subscriber = $post->subscribers()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs(User::factory()->create())
            ->{$method}($this->fillUri($uri, $post, $subscriber))
            ->assertForbidden();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Titolo']);
        $this->assertDatabaseCount('post_subscribers', 1);
    }

    #[DataProvider('protectedRoutes')]
    public function test_guest_is_redirected_to_login(string $method, string $uri): void
    {
        $post = $this->makePost();
        $subscriber = $post->subscribers()->create(['user_id' => User::factory()->create()->id]);

        $this->{$method}($this->fillUri($uri, $post, $subscriber))
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseCount('post_subscribers', 1);
    }

    private function fillUri(string $uri, Post $post, PostSubscriber $subscriber): string
    {
        return str_replace(['{post}', '{subscriber}'], [$post->id, $subscriber->id], $uri);
    }

    public function test_is_admin_cannot_be_set_at_registration(): void
    {
        $this->post('/register', [
            'name' => 'Lettore',
            'email' => 'lettore@example.com',
            'password' => 'Password-sicura-123',
            'password_confirmation' => 'Password-sicura-123',
            'is_admin' => true,
        ]);

        $this->assertFalse(User::where('email', 'lettore@example.com')->firstOrFail()->is_admin);
    }

    public function test_public_pages_are_readable_by_guests(): void
    {
        $post = $this->makePost();

        $this->get('/')->assertOk()->assertSee(Category::first()->name);
        $this->get(route('posts.index'))->assertOk();
        $this->get(route('posts.show', $post))->assertOk();
        $this->get(route('byCategory', $post->category))->assertOk()->assertSee(route('posts.show', $post));
    }

    public function test_admin_buttons_are_hidden_from_readers(): void
    {
        $post = $this->makePost();

        $this->actingAs(User::factory()->create())
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertDontSee('Modifica')
            ->assertDontSee('Elimina')
            ->assertDontSee('Nuovo Post')
            ->assertDontSee(route('admin.subscribers'));
    }

    public function test_admin_buttons_are_visible_to_admins(): void
    {
        $post = $this->makePost();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('Modifica')
            ->assertSee('Elimina')
            ->assertSee('Nuovo Post')
            ->assertSee(route('admin.subscribers'));
    }

    public function test_public_errors_are_in_italian(): void
    {
        app()->setLocale('it');

        $this->from('/login')
            ->post('/login', ['email' => 'nessuno@example.com', 'password' => 'sbagliata'])
            ->assertSessionHasErrors(['email' => 'Le credenziali inserite non sono corrette.']);

        $this->from('/register')
            ->post('/register', [])
            ->assertSessionHasErrors(['name' => 'Il campo nome è obbligatorio.']);
    }

    public function test_no_placeholder_links_remain_in_navigation_and_home(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get('/')
            ->assertOk()
            ->assertDontSee('Gestisci Categorie')
            ->assertDontSee('Contatti')
            ->assertSee('Leggi di più');
    }

    public function test_forgot_password_is_disabled(): void
    {
        $this->get('/forgot-password')->assertNotFound();
    }
}
