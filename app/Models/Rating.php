<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @tested */
final class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\RatingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'score',
        'comment',
    ];

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
