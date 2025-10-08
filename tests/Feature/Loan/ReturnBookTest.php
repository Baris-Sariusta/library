<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

test('that a user can return a book', function () : void
{
    $user = User::factory()
        ->withRole(UserRole::MEMBER)
        ->create();

    $book = Book::factory()->create();

    $loan = Loan::factory()
        ->for($user)
        ->for($book)
        ->asOngoing()
        ->create();

    $this->actingAs($user)
        ->patch(
            uri: "/api/loans/{$loan->id}",
            data: ['book_id' => $book->id],
        )
        ->assertOk();

    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'id' => $loan->id,
            'status' => LoanStatus::RETURNED,
        ]);
});
