<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Enums\LoanStatus;

/** @tested */
trait HasStatus
{
    /**
     * Determine whether the loan is still ongoing.
     */
    public function isOngoing() : bool
    {
        return $this->status === LoanStatus::ONGOING;
    }

    /**
     * Determine whether the loan is returned.
     */
    public function isReturned() : bool
    {
        return $this->status === LoanStatus::RETURNED;
    }

    /**
     * Mark the loan as returned.
     */
    public function markAsReturned() : void
    {
        $this->update([
            'status' => LoanStatus::RETURNED,
            'return_date' => now(),
        ]);
    }
}
