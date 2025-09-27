<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

test('that a user can borrow a book', function () : void
{
    $user = User::factory()
        ->withRole(UserRole::MEMBER)
        ->create();

    Book::factory()
        ->withStaticValues()
        ->create([
            'id' => 11,
        ]);

    // Borrow a book by sending a post request as a user...
    test()->actingAs($user)
        ->postJson(
            uri: '/api/loans',
            data: ['book_id' => '11'],
        )
        ->assertCreated();

    // Assert that the database has the newly created loan...
    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'book_id' => '11',
            'user_id' => $user->id,
            'loan_date' => now(),
            'status' => LoanStatus::ONGOING,
        ]);
});

it('fails if the book_id is missing', function () : void
{
    actingAsUser(role: UserRole::MEMBER)
        ->postJson(uri: '/api/loans', data: [
            'book_id' => null,
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('book_id');
});

it('fails if the book is already borrowed', function () : void
{
    $book = Book::factory()->create();

    // Create an ongoing loan for the book...
    Loan::factory()
        ->for($book)
        ->for(User::factory()->create())
        ->asOngoing()
        ->create();

    // Assert that the book can not be borrowed, since there is an ongoing loan...
    actingAsUser(role: UserRole::MEMBER)
        ->postJson(
            uri: '/api/loans',
            data: ['book_id' => $book->id]
        )
        ->assertStatus(422)
        ->assertJson([
            'message' => 'Dit boek is momenteel uitgeleend.',
        ]);
});
