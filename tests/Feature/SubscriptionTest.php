<?php

namespace Tests\Feature;

use App\Mail\PostSubscribed;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostSubscriber;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private const NOTIFY = 'notifiche@example.com';

    private Post $post;
    private User $reader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Mail::fake();
        config(['mail.notification_address' => self::NOTIFY]);
        $this->reader = User::factory()->create(['name' => 'Ada', 'email' => 'ada@example.com']);
        $this->post = Post::create([
            'title' => 'Elden Ring',
            'description' => 'Recensione',
            'category_id' => Category::first()->id,
        ]);
    }

    public function test_subscription_shows_a_confirmation_on_the_site(): void
    {
        $this->actingAs($this->reader)
            ->from(route('posts.show', $this->post))
            ->followingRedirects()
            ->post(route('posts.subscribe', $this->post), ['consent' => '1'])
            ->assertOk()
            ->assertSee('Iscrizione avvenuta con successo')
            ->assertSee('Sei iscritto a questo gioco.');

        $this->assertDatabaseHas('post_subscribers', ['post_id' => $this->post->id, 'user_id' => $this->reader->id]);
    }

    public function test_consent_is_required_and_recorded(): void
    {
        $this->actingAs($this->reader);

        $this->post(route('posts.subscribe', $this->post))->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('post_subscribers', 0);
        Mail::assertNothingSent();

        $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertSessionHasNoErrors();
        $this->assertNotNull(PostSubscriber::firstOrFail()->consent_at);
    }

    public function test_form_shows_the_consent_and_the_privacy_link(): void
    {
        $this->actingAs($this->reader)
            ->get(route('posts.show', $this->post))
            ->assertOk()
            ->assertSee('name="consent"', false)
            ->assertSee(route('privacy'));
    }

    public function test_privacy_page_shows_the_owner_and_promises_no_email(): void
    {
        config(['app.privacy_owner_name' => 'Titolare Prova', 'app.privacy_owner_email' => 'titolare@example.com']);

        $this->get(route('privacy'))
            ->assertOk()
            ->assertSee('Titolare Prova')
            ->assertSee('titolare@example.com')
            ->assertSee("registrare la tua iscrizione all'articolo", false)
            ->assertSee('Non vengono usati per inviarti email');
    }

    public function test_only_the_admin_is_notified_by_email(): void
    {
        $this->actingAs($this->reader)->post(route('posts.subscribe', $this->post), ['consent' => '1']);

        Mail::assertSentCount(1);
        Mail::assertSent(PostSubscribed::class, fn ($mail) => $mail->hasTo(self::NOTIFY) && ! $mail->hasTo('ada@example.com'));
    }

    public function test_notification_says_who_when_and_which_game(): void
    {
        $subscription = $this->post->subscribers()->create(['user_id' => $this->reader->id]);

        (new PostSubscribed($subscription))
            ->assertHasSubject('Nuova iscrizione al gioco: Elden Ring')
            ->assertSeeInHtml('Ada')
            ->assertSeeInHtml('ada@example.com')
            ->assertSeeInHtml($subscription->created_at->format('d/m/Y H:i'))
            ->assertSeeInHtml('Elden Ring');
    }

    public function test_duplicate_subscription_is_ignored(): void
    {
        $this->actingAs($this->reader);

        $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertSessionHas('success', 'Iscrizione avvenuta con successo');
        $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertSessionHas('success', 'Sei già iscritto a questo gioco.');

        $this->assertDatabaseCount('post_subscribers', 1);
        Mail::assertSentCount(1);
    }

    public function test_guest_cannot_subscribe_and_is_invited_to_log_in(): void
    {
        $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertRedirect(route('login'));
        $this->assertDatabaseCount('post_subscribers', 0);

        $this->get(route('posts.show', $this->post))
            ->assertOk()
            ->assertSee('Accedi per iscriverti a questo gioco.')
            ->assertDontSee(route('posts.subscribe', $this->post));
    }

    public function test_my_section_shows_only_my_subscriptions(): void
    {
        $otherPost = Post::create(['title' => 'Hollow Knight', 'description' => 'x']);
        $this->post->subscribers()->create(['user_id' => $this->reader->id]);
        $otherPost->subscribers()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($this->reader)
            ->get(route('subscriptions.index'))
            ->assertOk()
            ->assertSee('Elden Ring')
            ->assertDontSee('Hollow Knight');
    }

    public function test_my_section_requires_login_and_is_linked_in_the_menu(): void
    {
        $this->get(route('subscriptions.index'))->assertRedirect(route('login'));

        $this->actingAs($this->reader)->get('/')->assertOk()->assertSee(route('subscriptions.index'));
    }

    public function test_cancelling_removes_only_my_subscription(): void
    {
        $other = User::factory()->create();
        $this->post->subscribers()->create(['user_id' => $this->reader->id]);
        $this->post->subscribers()->create(['user_id' => $other->id]);

        $this->actingAs($this->reader)
            ->delete(route('posts.unsubscribe', $this->post))
            ->assertSessionHas('success', 'Iscrizione annullata.');

        $this->assertDatabaseMissing('post_subscribers', ['user_id' => $this->reader->id]);
        $this->assertDatabaseHas('post_subscribers', ['user_id' => $other->id]);
    }

    public function test_subscription_survives_an_smtp_failure(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new Exception('SMTP non raggiungibile'));

        $this->actingAs($this->reader)
            ->post(route('posts.subscribe', $this->post), ['consent' => '1'])
            ->assertSessionHas('success', 'Iscrizione avvenuta con successo');

        $this->assertDatabaseCount('post_subscribers', 1);
    }

    public function test_subscribing_is_rate_limited_per_user(): void
    {
        $this->actingAs($this->reader);

        foreach (range(1, 20) as $i) {
            $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertRedirect();
        }

        $this->post(route('posts.subscribe', $this->post), ['consent' => '1'])->assertTooManyRequests();

        $this->actingAs(User::factory()->create())
            ->post(route('posts.subscribe', $this->post), ['consent' => '1'])
            ->assertRedirect();
    }

    public function test_registration_is_rate_limited(): void
    {
        foreach (range(1, 5) as $i) {
            $this->post('/register', [])->assertRedirect();
        }

        $this->post('/register', [])->assertTooManyRequests();
        $this->get('/register')->assertOk();
    }

    public function test_admin_sees_who_when_and_which_game_and_can_delete(): void
    {
        $subscription = $this->post->subscribers()->create(['user_id' => $this->reader->id]);

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.subscribers'))
            ->assertOk()
            ->assertSee('Ada')
            ->assertSee('ada@example.com')
            ->assertSee($subscription->created_at->format('d/m/Y H:i'))
            ->assertSee('Elden Ring');

        $this->delete(route('admin.subscribers.destroy', $subscription))->assertRedirect(route('admin.subscribers'));

        $this->assertDatabaseCount('post_subscribers', 0);
    }

    public function test_deleting_a_post_or_a_user_removes_the_subscriptions(): void
    {
        $this->post->subscribers()->create(['user_id' => $this->reader->id]);
        $this->post->delete();
        $this->assertSame(0, PostSubscriber::count());

        $other = Post::create(['title' => 'Altro', 'description' => 'x']);
        $other->subscribers()->create(['user_id' => $this->reader->id]);
        $this->reader->delete();
        $this->assertSame(0, PostSubscriber::count());
    }

    public function test_newsletter_is_gone(): void
    {
        $this->get('/')->assertOk()->assertDontSee('newsletter');
        $this->post('/newsletter', ['email' => 'a@example.com'])->assertNotFound();
    }
}
