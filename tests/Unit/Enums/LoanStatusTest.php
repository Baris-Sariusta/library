<?php

declare(strict_types=1);

use App\Enums\LoanStatus;

it('should construct a LoanStatus enum', function (LoanStatus $status) : void
{
    expect($status)
        ->toBeInstanceOf(LoanStatus::class)
        ->name->toBeString()
        ->value->toBeString();
})->with(LoanStatus::cases());

it('should have the functions in the enum', function () : void
{
    expect(LoanStatus::ONGOING)->description()->toBe('Ongoing');
    expect(LoanStatus::RETURNED)->description()->toBe('Returned');
});
