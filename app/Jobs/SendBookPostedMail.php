<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\BookPosted;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

/** @tested */
final class SendBookPostedMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $userMail,
        protected string $bookId,
        protected string $bookTitle
    ) {}

    /**
     * Execute the job.
     *
     * This job sends a confirmation mail to the user.
     */
    public function handle() : void
    {
        Mail::to($this->userMail)->send(
            new BookPosted($this->bookId, $this->bookTitle),
        );
    }
}
