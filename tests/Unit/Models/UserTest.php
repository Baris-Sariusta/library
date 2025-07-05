<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

it('should construct a User model', function () : void
{
    expect(User::factory()->create())
        ->toBeInstanceOf(User::class)
        ->id->toBeInt()
        ->username->toBeString()
        ->first_name->toBeString()
        ->last_name->toBeString()
        ->email->toBeString()
        ->role->toBeString()
        ->admin->toBeBool()
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the User has all relations', function (string $name, string $relation) : void
{
    expect(relation(model: User::class, relation: $name))
        ->toBeInstanceOf($relation);
})->with([
    'ratings relation' => ['ratings', HasMany::class],
    'loans relation' => ['loans', HasMany::class],
]);
