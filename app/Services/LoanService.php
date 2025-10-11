<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Validation\ValidationException;

/** @tested */
final class LoanService
{
    /**
     * Borrow a book for a user.
     *
     * @param  array{book_id: int}  $data
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function borrowBook(array $data, User $user) : Loan
    {
        $book = Book::findOrFail($data['book_id']);

        // An exception should be thrown if the book is already borrowed...
        if (! $book->isAvailable())
        {
            throw ValidationException::withMessages([
                'book' => 'This book is already borrowed.',
            ]);
        }

        // Create a new loan record to mark the book as borrowed...
        return $book->borrow($user->id);
    }

    /**
     * Return a book that was borrowed.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function returnBook(Loan $loan) : Loan
    {
        // Only ongoing loans can be returned...
        if (! $loan->isOngoing())
        {
            throw ValidationException::withMessages([
                'book' => 'This book is already returned.',
            ]);
        }

        // Mark the loan as returned...
        $loan->markAsReturned();

        return $loan;
    }
}
