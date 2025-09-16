<?php

declare(strict_types=1);

namespace App\Enums;

enum LoanStatus : string
{
    case ONGOING = 'ongoing';
    case RETURNED = 'returned';

    /**
     * Get the description for the current loan status.
     */
    public function description() : string
    {
        return match ($this)
        {
            self::ONGOING => 'Ongoing',
            self::RETURNED => 'Returned',
        };
    }
}
