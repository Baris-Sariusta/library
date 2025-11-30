<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

final class BookPosted extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new message instance.
     */
    public function __construct(public int $bookId, public string $bookTitle) {}

    /**
     * Get the message envelope.
     */
    public function envelope() : Envelope
    {
        return new Envelope(
            subject: 'Book Posted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content() : Content
    {
        return new Content(
            view: 'mail.book-posted',

            // Define the fields that are needed in the mail view...
            with: [
                'id' => $this->bookId,
                'title' => $this->bookTitle,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments() : array
    {
        return [];
    }
}
