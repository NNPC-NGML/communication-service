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

    /**
     * The notification object.
     *
     * @var object
     */
    private object $notification;

    /**
     * Create a new message instance.
     *
     * @param object $notification The notification object containing email data.
     */
    public function __construct(object $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->notification->subject
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.message',
            with: [
                'title' => "Hello, {$this->notification->receiver}!",
                'message_body' => "{$this->notification->message_body}",
                'appName' => env('MAIL_FROM_NAME', 'NNPC-NGML'),
                'websiteUrl' => env('MAIL_WEBSITE'),
                'supportMail' => env('MAIL_SUPPORT'),
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
