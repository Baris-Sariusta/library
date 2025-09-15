<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\Models\User;

/** @untested */
final class LoanService
{
    /**
     * Borrow a book for a user.
     */
    public function borrowBook(Book $book, User $user) : Book
    {
        // Check if the book is available...
        $alreadyBorrowed = $book->loans()
            ->whereNull('return_date')
            ->exists();

        if ($alreadyBorrowed)
        {
            throw ValidationException::withMessages([
                'book' => 'Dit boek is al uitgeleend.',
            ]);
        }

        // add new loan...
        return $book->loans()->create([
            'user_id' => $user->id,
            'loan_date' => now(),
            'status' => 'borrowed',
        ]);
    }
}
