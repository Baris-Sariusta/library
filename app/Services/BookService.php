<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;

/** @tested */
final class BookService
{
    /**
     * Create a new book with the provided data and user.
     *
     * @param array{
     *     title: string,
     *     description: string|null,
     *     author_id: int,
     *     genre_ids: array<int, int>,
     *     published_at: string|null,
     *     language: string,
     *     price: float,
     *     publisher: string|null,
     *     cover_image: string|null,
     * } $data
     *
     * @return \App\Models\Book
     */
    public function createBook(array $data) : Book
    {
        // Query the Author so it can be linked
        // with the new book...
        $author = Author::findOrFail($data['author_id']);

        // Create the new book with the provided attributes...
        $book = Book::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'author_id' => $author->id,
            'published_at' => $data['published_at'] ?? null,
            'language' => $data['language'],
            'price' => $data['price'] ?? null,
            'publisher' => $data['publisher'] ?? null,
        ]);

        // Attach the associated genres, since these are in a pivot table...
        $book->genres()->attach($data['genre_ids']);

        return $book;
    }
}
