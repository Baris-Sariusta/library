<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @untested */
class Book extends Model
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
     * Get the authors for the book.
     */
    public function authors() : BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
