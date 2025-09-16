<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Validation\ValidationException;

/** @untested */
final class LoanService
{
    /**
     * Borrow a book for a user.
     */
    public function borrowBook(Book $book, User $user) : Loan
    {
        // An exception should be thrown if the book is already borrowed...
        if (! $book->isAvailable())
        {
            throw ValidationException::withMessages([
                'book' => 'Dit boek is momenteel uitgeleend.',
            ]);
        }

        // Create a new loan record to mark the book as borrowed...
        return $book->loans()->create([
            'user_id' => $user->id,
            'loan_date' => now(),
            'status' => LoanStatus::ONGOING,
        ]);
    }
}
