<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

/** @untested */
final class BookService
{
    /**
     * Create a new book with the provided data and user.
     */
    public function createBook(array $data, User $user) : Book
    {
        // Verify that the user has the required role...
        $this->checkUserRole($user);

        // Query the Author and Genre so it can be
        // linked with the new book...
        $author = Author::findOrFail($data['author_id']);
        $genre = Genre::findOrFail($data['genre_id']);

        // Create the new book with the provided attributes...
        return Book::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'author_id' => $author->id,
            'genre_id' => $genre->id,
            'published_at' => $data['published_at'] ?? null,
            'language' => $data['language'],
            'price' => $data['price'] ?? null,
            'publisher' => $data['publisher'] ?? null,
            'cover_image' => $data['cover_image'] ?? null,
        ]);
    }

    /**
     * Verify that the user is an admin or has
     * the 'librarian' or 'manager' role.
     */
    private function checkUserRole(User $user) : void
    {
        if (! ($user->isLibrarian() ||
            $user->isManager() ||
            $user->isAdmin())
        ) {
            throw new UnauthorizedException('The user is not authorized to add a book');
        }
    }
}
