<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Model;
use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @tested */
final class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'return_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => LoanStatus::class,
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

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

    /**
     * Determine whether the loan is still ongoing.
     */
    public function isOngoing() : bool
    {
        return $this->status === LoanStatus::ONGOING;
    }

    /*
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
