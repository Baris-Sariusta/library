<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;

/** @untested */
final class LoanService
{
    /**
     * Borrow a book for a user.
     */
    public function borrowBook(array $data) : Book
    {
        // check of het boek al is uitgeleend
        $alreadyBorrowed = $book->loans()
            ->whereNull('return_date')
            ->exists();

        if ($alreadyBorrowed) {
            throw ValidationException::withMessages([
                'book' => 'Dit boek is al uitgeleend.',
            ]);
        }

        // maak nieuwe loan aan
        return $book->loans()->create([
            'user_id'   => $user->id,
            'loan_date' => now(),
            'status'    => 'borrowed',
        ]);
    }
}
