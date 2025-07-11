<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

/** @untested */
final class BookPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create a book.
     */
    public function create(User $user) : bool
    {
        return $user->isLibrarian() || $user->isManager() || $user->isAdmin();
    }
}
