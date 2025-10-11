<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

it('should construct a Loan model', function () : void
{
    expect(Loan::factory()->withReturnDate()->create()) // Force the optional 'return_date' to always be present...
        ->toBeInstanceOf(Loan::class)
        ->id->toBeInt()
        ->user_id->toBeInt()
        ->book_id->toBeInt()
        ->loan_date->toBeInstanceOf(Carbon::class)
        ->return_date->toBeInstanceOf(Carbon::class)
        ->status->toBeInstanceOf(LoanStatus::class)
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the Loan has all relations', function (string $name, string $relation) : void
{
    expect(relation(model: Loan::class, relation: $name))
        ->toBeInstanceOf($relation);
})->with([
    'user relation' => ['user', BelongsTo::class],
    'book relation' => ['book', BelongsTo::class],
]);

it('can determine whether the loan is ongoing', function () : void
{
    $loan = Loan::factory()->asReturned()->create();

    // Make sure the loan status is not ongoing...
    expect($loan->isOngoing())->toBeFalse();

    // Update the loan status to ongoing...
    $loan->update(['status' => LoanStatus::ONGOING]);

    // Make sure the loan is ongoing...
    expect($loan->isOngoing())->toBeTrue();
});

it('can mark the loan as returned', function () : void
{
    // Set the date for the test...
    Carbon::setTestNow('01-01-2025');

    $loan = Loan::factory()->asOngoing()->create();

    $loan->markAsReturned();

    // Make sure the loan is marked as returned and has the correct return_date...
    expect($loan->status)->toBe(LoanStatus::RETURNED)
        ->and($loan->return_date)->toEqual(Carbon::parse('2025-01-01'));

    // Also assert that the database has the loan record...
    $this->assertDatabaseHas(table: Loan::getTableName(), data: [
        'status' => LoanStatus::RETURNED,
        'return_date' => '2025-01-01',
    ]);
});
