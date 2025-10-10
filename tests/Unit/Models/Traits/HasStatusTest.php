<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Models\Loan;

it('can determine the ongoing status', function () : void
{
    $loan = Loan::factory()
        ->withStatus(LoanStatus::ONGOING)
        ->create();

    expect($loan->isOngoing())->toBeTrue();
    expect($loan->isReturned())->toBeFalse();
});

it('can determine the librarian role', function () : void
{
    $loan = Loan::factory()
        ->withStatus(LoanStatus::RETURNED)
        ->create();

    expect($loan->isOngoing())->toBeFalse();
    expect($loan->isReturned())->toBeTrue();
});

it('can mark an ongoing loan as returned', function () : void
{
    // Make sure there is a loan with the status of 'ongoing'...
    $loan = Loan::factory()
        ->withStatus(LoanStatus::ONGOING)
        ->create();

    // Make sure the loan is not returned...
    expect($loan->isReturned())->toBeFalse();

    // Mark the loan as returned...
    $loan->markAsReturned();

    // Now the loan should be marked as returned...
    expect($loan->isReturned())->toBeTrue();
});
