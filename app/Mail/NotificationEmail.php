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
                'message_body' => "{$this->notification->message_body}",
                'appName' => "NNPC",
                'websiteUrl' => 'https://website.com',
                'logoUrl' => 'https://firebasestorage.googleapis.com/v0/b/server-sec5.appspot.com/o/nnpc-logo.png?alt=media',
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
