<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Validation\ValidationException;

beforeEach(function () : void
{
    $this->loanService = app(LoanService::class);

    $this->user = User::factory()
        ->asMember()
        ->create([
            'id' => 22,
        ]);

    $this->book = Book::factory()
        ->withStaticValues()
        ->create([
            'id' => 11,
        ]);
});

it('borrows a book for a user', function () : void
{
    $loan = $this->loanService->borrowBook(
        data: ['book_id' => $this->book->id],
        user: $this->user,
    );

    expect($loan)
        ->toBeInstanceOf(Loan::class)
        ->user_id->toBe(22)
        ->status->toBe(LoanStatus::ONGOING)
        ->book_id->toBe(11);

    // Assert that the loans table has the given data...
    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'user_id' => 22,
            'book_id' => 11,
        ]);
});

test('throws a validation error if the book is already borrowed', function () : void
{
    // Create an ongoing loan for the book...
    Loan::factory()
        ->for($this->book)
        ->for(User::factory()->create())
        ->asOngoing()
        ->create();

    // Assert that the book can not be borrowed, since there is an ongoing loan...
    $this->loanService->borrowBook(
        data: ['book_id' => $this->book->id],
        user: $this->user,
    );
})->throws(
    exception: ValidationException::class,
    exceptionMessage: 'This book is already borrowed.',
);

test('that a user can return a book', function () : void
{
    $book = Book::factory()->create();

    // Create a loan record for the book...
    $loan = Loan::factory()
        ->for($book)
        ->asOngoing()
        ->create();

    $this->loanService->returnBook($loan);

    expect($loan)
        ->toBeInstanceOf(Loan::class)
        ->status->toBe(LoanStatus::RETURNED)
        ->book_id->toBe($book->id);

    // Assert that the loans table has the given data...
    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'status' => LoanStatus::RETURNED,
            'return_date' => now()->format('Y-m-d'),
            'book_id' => $book->id,
        ]);
});

it('fails if the loan is already returned', function () : void
{
    $loan = Loan::factory()
        ->asReturned()
        ->create();

    $this->loanService->returnBook($loan);
})->throws(
    exception: ValidationException::class,
    exceptionMessage: 'This book is already returned.',
);
