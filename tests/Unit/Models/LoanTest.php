<?php

declare(strict_types=1);

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
        ->status->toBeString()
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
