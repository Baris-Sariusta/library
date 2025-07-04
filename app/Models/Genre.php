<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** @untested */
class Genre extends Model
{
    /** @use HasFactory<\Database\Factories\GenreFactory> */
    use HasFactory;

    /**
     * Get the books for the genre.
     */
    public function books() : BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
