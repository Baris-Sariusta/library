<?php

declare(strict_types=1);

use App\Models\Author;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

it('should construct an Author model', function () : void
{
    expect(Author::factory()->create())
        ->toBeInstanceOf(Author::class)
        ->id->toBeInt()
        ->name->toBeString()
        ->email->toBeString()
        ->bio->toBeString()
        ->birth_date->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class)
        ->updated_at->toBeInstanceOf(Carbon::class);
});

test('that the Author has a HasMany relation with Book', function () : void
{
    expect(relation(model: Author::class, relation: 'books'))
        ->toBeInstanceOf(HasMany::class);
});
