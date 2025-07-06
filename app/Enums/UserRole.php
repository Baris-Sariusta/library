<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole : int
{
    case MEMBER = 1;
    case LIBRARIAN = 2;
    case MANAGER = 3;

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
