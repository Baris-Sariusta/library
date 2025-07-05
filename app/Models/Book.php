<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Model;
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
        'published_at',
        'description',
        'genre',
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
}
