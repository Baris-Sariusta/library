<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;

beforeEach(function () : void
{
    $bookService = app(BookService::class);

    $this->book = $bookService->createBook(
        data: [
            'title' => 'foo',
            'author_id' => $this->author_id = Author::factory()->create()->id,
            'genre_ids' => $this->genre_ids = [Genre::factory()->create()->id],
            'language' => 'bar',
        ],
        user: User::factory()->withRole(UserRole::LIBRARIAN)->create()
    );
});

it('creates a book without optional fields and sets defaults to null', function () : void
{
    expect($this->book)
        ->toBeInstanceOf(Book::class)
        ->title->toBe('foo')
        ->description->toBeNull()
        ->published_at->toBeNull()
        ->price->toBeNull()
        ->publisher->toBeNull()
        ->cover_image->toBeNull()
        ->author_id->toBe($this->author_id);

    // Assert that the books table has the given data...
    $this->assertDatabaseHas(
        table: Book::class,
        data: [
            'id' => $this->book->id,
            'title' => 'foo',
            'author_id' => $this->author_id,
        ]);
});

it('attaches correct genres to the book', function () : void
{
    expect($this->book->genres()->pluck('genre_id')->toArray())
        ->toBe($this->genre_ids);

    // Assert that the pivot table has the correct book and genre...
    $this->assertDatabaseHas(table: 'book_genre', data: [
        'book_id' => $this->book->id,
        'genre_id' => $this->genre_ids,
    ]);
});

it('throws UnauthorizedException when user has no valid role', function () : void
{
    $bookService = app(BookService::class);

    $bookService->createBook(
        data: [
            'title' => 'foo',
            'author_id' => Author::factory()->create()->id,
            'genre_ids' => [Genre::factory()->create()->id],
            'language' => 'bar',
        ],
        user: User::factory()->withRole(UserRole::MEMBER)->create(),
    );
})->throws(UnauthorizedException::class, 'The user is not authorized to add a book');

it('throws ModelNotFoundException when author does not exist', function () : void
{
    $bookService = app(BookService::class);

    $bookService->createBook(
        data: [
            'title' => 'foo',
            'author_id' => 9999, // non-existing author id...
            'genre_ids' => [Genre::factory()->create()->id],
            'language' => 'bar',
        ],
        user: User::factory()->withRole(UserRole::LIBRARIAN)->create()
    );
})->throws(ModelNotFoundException::class);
