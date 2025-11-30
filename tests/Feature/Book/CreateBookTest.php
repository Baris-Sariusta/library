<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Mail\BookPosted;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;

beforeEach(function () : void
{
    $this->payload = [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author_id = Author::factory()->create()->id,
        'genre_ids' => [Genre::factory()->create()->id], // Must be an array according to StoreBookRequest rules...
        'published_at' => $date = now()->format('Y-m-d'),
        'language' => 'baz',
        'price' => 29.99,
        'publisher' => 'fop',
    ];

    $this->expectedData = fn () : array => [
        'title' => 'foo',
        'description' => 'bar',
        'author_id' => $author_id,
        'published_at' => $date,
        'language' => 'baz',
        'price' => '29.99',
        'publisher' => 'fop',
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
})->with([[
    UserRole::LIBRARIAN,
    UserRole::MANAGER,
]]);

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

it('validates missing required fields', function (array $invalidPayloads, string $expectedErrors) : void
{
    actingAsUser(role: UserRole::LIBRARIAN)
        ->postJson(uri: '/api/books', data: $invalidPayloads)
        ->assertStatus(422)
        ->assertJsonValidationErrors($expectedErrors);
})->with([
    'payload with missing title' => fn () : array => [collect($this->payload)->except('title')->toArray(), 'title'],
    'payload with missing author' => fn () : array => [collect($this->payload)->except('author_id')->toArray(), 'author_id'],
    'payload with missing genres' => fn () : array => [collect($this->payload)->except('genre_ids')->toArray(), 'genre_ids'],
    'payload with missing price' => fn () : array => [collect($this->payload)->except('price')->toArray(), 'price'],
]);

it('pushes the confirmation mail to the queue when a book is created', function () : void
{
    Mail::fake();

    $user = User::factory()
        ->withEmail('test@example.com')
        ->withRole(UserRole::LIBRARIAN)
        ->create();

    // Ensure that the mail job is not pushed to the queue...
    Mail::assertNotQueued(BookPosted::class);

    // Create a new book...
    $this->actingAs($user)
        ->postJson(uri: '/api/books', data: $this->payload)
        ->assertCreated();

    // Ensure that the mail job is pushed to the queue for the correct user...
    Mail::assertQueued(BookPosted::class, function (BookPosted $mail) : bool
    {
        return $mail->hasTo('test@example.com');
    });
});
