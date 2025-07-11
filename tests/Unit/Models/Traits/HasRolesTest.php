<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;

it('can determine the member role', function ()
{
    $user = User::factory()->withRole(UserRole::MEMBER)->create();

    expect($user->isMember())->toBeTrue();
    expect($user->isLibrarian())->toBeFalse();
    expect($user->isManager())->toBeFalse();
});

it('can determine the librarian role', function ()
{
    $user = User::factory()->withRole(UserRole::LIBRARIAN)->create();

    expect($user->isMember())->toBeFalse();
    expect($user->isLibrarian())->toBeTrue();
    expect($user->isManager())->toBeFalse();
});

it('can determine the manager role', function ()
{
    $user = User::factory()->withRole(UserRole::MANAGER)->create();

    expect($user->isMember())->toBeFalse();
    expect($user->isLibrarian())->toBeFalse();
    expect($user->isManager())->toBeTrue();
});
