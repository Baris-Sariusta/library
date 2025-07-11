<?php

declare(strict_types=1);

use App\Enums\UserRole;

it('should construct a UserRole enum', function (UserRole $role) : void
{
    expect($role)
        ->name->toBeString()
        ->value->toBeString();
})->with(UserRole::cases());

it('should have the description function', function () : void
{
    expect(UserRole::MEMBER)->description()->toBe('Member');
    expect(UserRole::LIBRARIAN)->description()->toBe('Librarian');
    expect(UserRole::MANAGER)->description()->toBe('Manager');
});
