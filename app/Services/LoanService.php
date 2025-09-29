<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\LoanStatus;
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
        return $book->loans()->create([
            'user_id' => $user->id,
            'loan_date' => now(),
            'status' => LoanStatus::ONGOING,
        ]);
    }

    /**
     * Return a book that was borrowed.
     *
     * @param array{...}  $data
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function returnBook(array $data, Loan $loan, User $user) : Loan
    {
        // Ensure the loan belongs to the authenticated user...
        if ($loan->user_id !== $user->id)
        {
            throw validationException::withMessages('This loan is not yours.');
        }

        // Ensure that the given book_id matches the id of the loan...
        if($data['book_id'] !== $loan->book_id)
        {
            throw validationException::withMessages('Book ID does not match this loan.');
        }

        // Only ongoing loans can be returned...
        if (! $loan->isOngoing())
        {
            throw validationException::withMessages('This loan cannot be returned.');
        }

        // Update the status and return_date fields...
        $loan->update([
            'status' => LoanStatus::RETURNED,
            'return_date' => now(),
        ]);

        return $loan;
    }
}
