<?php

declare(strict_types=1);

use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

it('should construct a Book model', function () : void
{
    expect(Book::factory()->create())
        ->toBeInstanceOf(Book::class)
        ->id->toBeInt()
        ->title->toBeString()
        ->description->toBeString()
        ->published_at->toBeInstanceOf(Carbon::class)
        ->language->toBeString()
        ->price->toBeFloat()
        ->publisher->toBeString()
        ->average_rating->toBeInt()
        ->cover_image->toBeString()
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the Book has all relations', function (string $name, string $relation) : void
{
    expect(relation(model: Book::class, relation: $name))
        ->toBeInstanceOf($relation);
})->with([
    'author relation' => ['author', BelongsTo::class],
    'ratings relation' => ['ratings', HasMany::class],
    'genres relation' => ['genres', BelongsToMany::class],
    'loans relation' => ['loans', HasMany::class],
]);
