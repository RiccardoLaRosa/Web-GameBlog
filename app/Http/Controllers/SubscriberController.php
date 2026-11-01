<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Post;
use App\Mail\PostSubscribed;
use App\Models\PostSubscriber;
use App\Http\Requests\PostSubscriberRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class SubscriberController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware('auth'),
            new Middleware('can:admin', only: ['index', 'destroy']),
        ];
    }

    public function index() {
        $subscriptions = PostSubscriber::with(['user','post'])->latest()->paginate(25);
        return view('admin.subscribers', compact('subscriptions'));
    }

    public function mine() {
        $subscriptions = Auth::user()->subscriptions()->with('post.category')->latest()->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function store(PostSubscriberRequest $request, Post $post) {
        $subscription = $post->subscribers()->createOrFirst(
            ['user_id' => Auth::id()],
            ['consent_at' => now()],
        );

        if (! $subscription->wasRecentlyCreated) {
            return redirect()->back()->with('success', 'Sei già iscritto a questo gioco.');
        }

        $this->notifyAdmin($subscription);

        return redirect()->back()->with('success', 'Iscrizione avvenuta con successo');
    }

    public function cancel(Post $post) {
        $post->subscribers()->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Iscrizione annullata.');
    }

    public function destroy(PostSubscriber $subscriber) {
        $subscriber->delete();
        return redirect()->route('admin.subscribers')->with('success', 'Iscrizione eliminata.');
    }

    // L'iscrizione resta salvata anche se l'SMTP non risponde: l'errore finisce nel log.
    private function notifyAdmin(PostSubscriber $subscription): void {
        try {
            Mail::to(config('mail.notification_address'))->send(new PostSubscribed($subscription));
        } catch (Throwable $e) {
            report($e);
        }
    }
}
