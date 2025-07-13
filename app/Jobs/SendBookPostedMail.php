<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\BookPosted;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

final class SendBookPostedMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public Book $book)
    {
        //
    }

    /**
     * Execute the job.
     *
     * This job sends a confirmation mail to the user.
     */
    public function handle() : void
    {
        Mail::to($this->user)->queue(
            new BookPosted($this->book),
        );
    }
}
