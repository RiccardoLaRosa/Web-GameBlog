<?php

namespace App\Mail;

use App\Models\PostSubscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PostSubscribed extends Mailable
{
    public function __construct(public PostSubscriber $subscription)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Nuova iscrizione al gioco: '.$this->subscription->post->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.post-subscribed');
    }
}
