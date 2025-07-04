<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @untested */
final class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\RatingFactory> */
    use HasFactory;

    /**
     * Get the book for the rating.
     */
    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user for the rating.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
