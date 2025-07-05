<?php

declare(strict_types=1);

use App\Models\Rating;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

it('should construct a Rating model', function () : void
{
    expect(Rating::factory()->create())
        ->toBeInstanceOf(Rating::class)
        ->id->toBeInt()
        ->user_id->toBeInt()
        ->book_id->toBeInt()
        ->score->toBeInt()
        ->comment->toBeString()
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the Rating has all relations', function (string $name, string $relation) : void
{
    expect(relation(model: Rating::class, relation: $name))
        ->toBeInstanceOf($relation);
})->with([
    'book relation' => ['book', BelongsTo::class],
    'user relation' => ['user', BelongsTo::class],
]);
