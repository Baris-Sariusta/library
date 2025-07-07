<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole : string
{
    case MEMBER = 'member';
    case LIBRARIAN = 'librarian';
    case MANAGER = 'manager';

    /**
     * Get the description for the current user role.
     */
    public function description() : string
    {
        return match ($this)
        {
            self::MEMBER => 'Member',
            self::LIBRARIAN => 'Library',
            self::MANAGER => 'Manager',
        };
    }
}
