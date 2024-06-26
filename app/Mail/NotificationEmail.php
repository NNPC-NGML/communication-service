<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private object $notification;

    /**
     * Create a new message instance.
     */
    public function __construct(object $notification)
    {
        //
        $this->notification=$notification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->notification->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.message',
            with: [
                'title' => "Hello, {$this->notification->receiver}!",
                'message' => $this->notification->message,
                'appName' => "NNPC",
                'websiteUrl' => 'https://website.com',
                'logoUrl' => 'https://goldenhousest.com/wp-content/uploads/elementor/thumbs/logoipsum-logo-291-2-pbdagt3d6eoe13dh8p43mykjns17r67fbj0jl3vmcg.png',
                'supportMail' => 'support@mail.com',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
