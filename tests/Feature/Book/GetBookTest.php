<?php

declare(strict_types=1);

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;

beforeEach(function () : void
{
    $this->genre = Genre::factory()->withTitle('foo')->create();

    $this->author = Author::factory()
        ->withName('bar')
        ->create([
            'bio' => 'baz', 'birth_date' => '2000-01-01',
        ]);

    // Generate books with placeholder data, each linked to the same author and genre...
    $this->books = Book::factory()
        ->withStaticValues()
        ->for($this->author)
        ->hasAttached(factory: $this->genre, relationship: 'genres') // Attach the genre to the factory...
        ->forEachSequence(
            ['title' => 'foo', 'description' => 'bar', 'average_rating' => 2, 'published_at' => '2025-01-01', 'price' => 10.00],
            ['title' => 'baz', 'description' => 'bax', 'average_rating' => 4, 'published_at' => '2025-02-01', 'price' => 20.00],
        )
        ->create();
});

it('can retrieve a single book with its author and genres', function () : void
{
    $book_id = $this->books[0]->id;

    $response = actingAsUser()
        ->getJson(uri: "/api/books/{$book_id}")
        ->assertOk();

    // Extract main attributes from API response...
    $data = $response->json('data.attributes');

    expect($data)->toMatchArray([
        'title' => 'foo',
        'description' => 'bar',
        'average_rating' => 2,
        'author' => [
            'attributes' => [
                'name' => 'bar',
                'bio' => 'baz',
                'birth_date' => '1999-12-31T23:00:00.000000Z', // Factory value (2000-01-01) is converted to UTC ISO8601 in API response...
            ],
            'type' => 'author',
            'id' => $this->author->id,
        ],
        'genres' => [
            [
                'attributes' => [
                    'title' => 'foo',
                ],
                'type' => 'genre',
                'id' => $this->genre->id,
            ],
        ],
        'published_at' => '2024-12-31T23:00:00.000000Z', // Factory value (2025-01-01) is converted to UTC ISO8601 in API response...
        'language' => 'baz',
        'price' => 10.00,
        'publisher' => 'bax',
        'cover_image' => 'fop',
    ]);
});

it('can retrieve a list of books with its author and genres', function () : void
{
    $response = actingAsUser()
        ->getJson('/api/books')
        ->assertOk();

    // Extract books array from API response...
    $books = $response->json('data');

    expect($books)->toHaveCount(2);

    expect($books[0]['attributes'])->toMatchArray([
        'title' => 'foo',
        'description' => 'bar',
        'average_rating' => 2,
        'author' => [
            'attributes' => [
                'name' => 'bar',
                'bio' => 'baz',
                'birth_date' => '1999-12-31T23:00:00.000000Z', // Factory value (2000-01-01) is converted to UTC ISO8601 in API response...
            ],
            'type' => 'author',
            'id' => $this->author->id,
        ],
        'genres' => [
            [
                'attributes' => [
                    'title' => 'foo',
                ],
                'type' => 'genre',
                'id' => $this->genre->id,
            ],
        ],
        'published_at' => '2024-12-31T23:00:00.000000Z', // Factory value (2025-01-01) is converted to UTC ISO8601 in API response...
        'language' => 'baz',
        'price' => 10.00,
        'publisher' => 'bax',
        'cover_image' => 'fop',
    ]);

    expect($books[1]['attributes'])->toMatchArray([
        'title' => 'baz',
        'description' => 'bax',
        'average_rating' => 4,
        'author' => [
            'attributes' => [
                'name' => 'bar',
                'bio' => 'baz',
                'birth_date' => '1999-12-31T23:00:00.000000Z', // Factory value (2000-01-01) is converted to UTC ISO8601 in API response...
            ],
            'type' => 'author',
            'id' => $this->author->id,
        ],
        'genres' => [
            [
                'attributes' => [
                    'title' => 'foo',
                ],
                'type' => 'genre',
                'id' => $this->genre->id,
            ],
        ],
        'published_at' => '2025-01-31T23:00:00.000000Z', // Factory value (2025-01-01) is converted to UTC ISO8601 in API response...
        'language' => 'baz',
        'price' => 20.00,
        'publisher' => 'bax',
        'cover_image' => 'fop',
    ]);
});
