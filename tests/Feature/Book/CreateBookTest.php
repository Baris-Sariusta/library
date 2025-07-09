<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $author = Author::factory()
        ->withName('foo')
        ->create();

    $genre = Genre::factory()
        ->withTitle('foo')
        ->create();

    $date = now()->format('Y-m-d');
    $img = UploadedFile::fake()->image('wop.jpg');

    $this->payload = [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author->id,
        'genre_ids' => [$genre->id],
        'published_at' => $date = now()->format('Y-m-d'),
        'language' => 'baz',
        'price' => 29.99,
        'publisher' => 'fop',
        'cover_image' => $img,
    ];

    $this->expectedData = fn () : array => [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author->id,
        'published_at' => $date,
        'language' => 'baz',
        'price' => '29.99', // let op string vs float in DB!
        'publisher' => 'fop',
        'cover_image' => $img,
    ];
});

test('that a librarian or manager can create a book in the database', function (UserRole $role) : void
{
    $user = User::factory()
        ->withRole($role)
        ->create();

    // Create a new book by sending a post request as a user...
    actingAsUser($user)
        ->post(uri: '/api/books', data: $this->payload)
        ->assertCreated();

    // Assert that the database has the newly created book...
    $this->assertDatabaseHas(
        table: Book::getTableName(),
        data: ($this->expectedData)(),
    );
})->with([
    'user role' => [
        UserRole::LIBRARIAN,
        UserRole::MANAGER,
    ]
]);

test('that an admin can create a book in the database', function (): void {
    $user = User::factory()
        ->asAdmin()
        ->create();

    actingAsUser($user)
        ->post('/api/books', $this->payload)
        ->assertCreated();

    // Assert that the database has the newly created book...
    $this->assertDatabaseHas(
        table: Book::getTableName(),
        data: ($this->expectedData)(),
    );
});

it('forbids a user with the member role to add a book', function () : void
{
    $user = User::factory()
        ->asMember()
        ->create();

    actingAsUser($user)
        ->post(uri: '/api/books', data: $this->payload)
        ->assertForbidden();
});

it('prevents creating duplicate books', function () : void
{
    // ..
});

