<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\UploadedFile;

beforeEach(function () : void
{
    $this->payload = [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author = Author::factory()->create()->id,
        'genre_ids' => [Genre::factory()->create()->id], // Must be an array according to StoreBookRequest rules...
        'published_at' => $date = now()->format('Y-m-d'),
        'language' => 'baz',
        'price' => 29.99,
        'publisher' => 'fop',
        'cover_image' => $img = UploadedFile::fake()->image('wop.jpg'),
    ];

    $this->expectedData = fn () : array => [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author,
        'published_at' => $date,
        'language' => 'baz',
        'price' => '29.99',
        'publisher' => 'fop',
        'cover_image' => $img,
    ];
});

test('that a librarian or manager can create a book in the database', function (UserRole $role) : void
{
    // Create a new book by sending a post request as a user...
    actingAsUser(role: $role)
        ->postJson(uri: '/api/books', data: $this->payload)
        ->assertCreated();

    // Assert that the database has the newly created book...
    $this->assertDatabaseHas(
        table: Book::getTableName(),
        data: ($this->expectedData)(),
    );
})->with([
    'user roles' => [
        UserRole::LIBRARIAN,
        UserRole::MANAGER,
    ],
]);

test('that an admin can create a book in the database', function () : void
{
    actingAsAdmin()
        ->postJson('/api/books', $this->payload)
        ->assertCreated();

    // Assert that the database has the newly created book...
    $this->assertDatabaseHas(
        table: Book::getTableName(),
        data: ($this->expectedData)(),
    );
});

it('forbids a user with the member role to add a book', function () : void
{
    actingAsUser(role: UserRole::MEMBER)
        ->postJson(uri: '/api/books', data: $this->payload)
        ->assertForbidden();
});

it('prevents creating duplicate books', function () : void
{
    // First post request should succeed...
    actingAsUser(role: UserRole::LIBRARIAN)
        ->post(uri: '/api/books', data: $this->payload)
        ->assertCreated();

    // Assert that the database has the data...
    $this->assertDatabaseHas(table: Book::getTableName(), data: ($this->expectedData)());

    // Second post request should fail...
    actingAsUser(role: UserRole::LIBRARIAN)
        ->postJson(uri: '/api/books', data: $this->payload)
        ->assertStatus(422);

    // Assert that the database only has one record...
    expect(Book::query()->count())
        ->toBeOne();
});
