<?php

declare(strict_types=1);

use App\Models\Genre;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

it('should construct a Genre model', function () : void
{
    expect(Genre::factory()->create())
        ->toBeInstanceOf(Genre::class)
        ->id->toBeInt()
        ->title->toBeString()
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the Genre has a BelongsToMany relation with Book', function () : void
{
    expect(relation(model: Genre::class, relation: 'books'))
        ->toBeInstanceOf(BelongsToMany::class);
});
