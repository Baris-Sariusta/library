<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class BookPosted extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Book $book) {}

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
                'id' => $this->book->id,
                'title' => $this->book->title,
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
