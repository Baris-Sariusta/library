<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Enums\UserRole;

/** @tested */
trait HasRoles
{
    /**
     * Determine if the user role is 'member'.
     */
    public function isMember() : bool
    {
        return $this->role === UserRole::MEMBER;
    }

    /**
     * Determine if the user role is 'librarian'.
     */
    public function isLibrarian() : bool
    {
        return $this->role === UserRole::LIBRARIAN;
    }

    /**
     * Determine if the user role is 'manager'.
     */
    public function isManager() : bool
    {
        return $this->role === UserRole::MANAGER;
    }
}
