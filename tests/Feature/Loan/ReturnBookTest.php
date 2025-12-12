<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

beforeEach(function () : void
{
    $this->user = User::factory()
        ->withRole(UserRole::MEMBER)
        ->create();

    $this->book = Book::factory()->create();

    // Make sure there is an ongoing loan...
    $this->loan = Loan::factory()
        ->for($this->user)
        ->for($this->book)
        ->asOngoing()
        ->create();
});

test('that a user can return a book', function () : void
{
    $this->actingAs($this->user)
        ->patchJson(
            uri: "/api/loans/{$this->loan->id}",
            data: ['book_id' => $this->book->id],
        )
        ->assertOk();

    // Assert that the database has the correct columns...
    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'id' => $this->loan->id,
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => LoanStatus::RETURNED,
            'return_date' => now()->format('Y-m-d'),
        ]);
});

test('that the book id should match the book of the loan', function () : void
{
    $otherBook = Book::factory()->create();

    // Create a request with the same user and loan id,
    // but for another book...
    $this->actingAs($this->user)
        ->patchJson(
            uri: "/api/loans/{$this->loan->id}",
            data: ['book_id' => $otherBook->id],
        )

        // Assert that the FormRequest returns a 422 response
        // with the expected validation error...
        ->assertInvalid([
            'book_id' => 'The given book id does not match this loan.',
        ]);
});

test('that the user should match the user id of the loan', function () : void
{
    $otherUser = User::factory()->asMember()->create();

    // Create a request with the same book and loan id,
    // but with another user...
    $this->actingAs($otherUser)
        ->patchJson(
            uri: "/api/loans/{$this->loan->id}",
            data: ['book_id' => $this->book->id],
        )

        // Assert that the user is unauthorized for this action...
        ->assertForbidden();
});

test('that only ongoing loans can be returned', function () : void
{
    // Make sure there is a returned loan...
    $loan = Loan::factory()
        ->for($this->user)
        ->for($this->book)
        ->asReturned()
        ->create();

    $this->actingAs($this->user)
        ->patchJson(
            uri: "/api/loans/{$loan->id}",
            data: ['book_id' => $this->book->id],
        )
        ->assertStatus(422)
        ->assertJson([
            'message' => 'This book is already returned.',
        ]);
});
