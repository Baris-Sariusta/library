<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @untested */
class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    /**
     * Get the user for the loan.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book for the loan.
     */
    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
