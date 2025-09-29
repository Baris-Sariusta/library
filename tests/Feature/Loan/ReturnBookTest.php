<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Models\Loan;
use App\Models\User;
use App\Enums\UserRole;

test('that a user can return a book', function () : void
{
    $user = User::factory()
        ->withRole(UserRole::MEMBER)
        ->create();

    $loan = Loan::factory()
        ->for($user)
        ->asOngoing()
        ->create();

    $this->actingAs($user)
        ->patch(
            uri: "/api/loans/{$loan->id}",
            data: ['book_id' => '1'],
        )
        ->assertOk();

    $this->assertDatabaseHas(
        table: Loan::getTableName(),
        data: [
            'id' => $loan->id,
            'status' => LoanStatus::RETURNED,
        ]);
});
