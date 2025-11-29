<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Model;
use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @tested */
final class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'genre_id',
        'published_at',
        'language',
        'price',
        'publisher',
        'cover_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * Get the author for the book.
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the ratings for the book.
     */
    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the genres for the book.
     */
    public function genres() : BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Get the loans for the book.
     */
    public function loans() : HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Determine whether the book can currently be borrowed.
     */
    public function isAvailable() : bool
    {
        // A book is considered available if there are no ongoing loans...
        return $this->loans()
            ->where('status', LoanStatus::ONGOING)
            ->doesntExist();
    }

    /**
     * Borrow the book for the given user.
     */
    public function borrow(int $user_id) : Loan
    {
        return $this->loans()->create([
            'user_id' => $user_id,
            'loan_date' => now(),
            'status' => LoanStatus::ONGOING,
        ]);
    }
}
