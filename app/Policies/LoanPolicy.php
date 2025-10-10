<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

/** @untested-ignore */
final class LoanPolicy
{
    /**
     * Determine whether the user can update a loan.
     */
    public function update(User $user, Loan $loan) : bool
    {
        // Ensure that the loan belongs to the user of this request...
        return $loan->user_id === $user->id;
    }
}
