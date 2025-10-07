<?php

declare(strict_types=1);

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

beforeEach(function () : void
{
    $this->book = Book::factory()->create();
});

it('should construct a Book model', function () : void
{
    expect($this->book)
        ->toBeInstanceOf(Book::class)
        ->id->toBeInt()
        ->title->toBeString()
        ->description->toBeString()
        ->published_at->toBeInstanceOf(Carbon::class)
        ->language->toBeString()
        ->price->toBeFloat()
        ->publisher->toBeString()
        ->average_rating->toBeInt()
        ->cover_image->toBeString()
        ->updated_at->toBeInstanceOf(Carbon::class)
        ->created_at->toBeInstanceOf(Carbon::class);
});

test('that the Book has all relations', function (string $name, string $relation) : void
{
    expect(relation(model: Book::class, relation: $name))
        ->toBeInstanceOf($relation);
})->with([
    'author relation' => ['author', BelongsTo::class],
    'ratings relation' => ['ratings', HasMany::class],
    'genres relation' => ['genres', BelongsToMany::class],
    'loans relation' => ['loans', HasMany::class],
]);

it('can determine whether the book is available', function () : void
{
    // The book should be available, since it is not borrowed...
    expect($this->book->isAvailable())
        ->toBeTrue();

    // Create a loan record for the book...
    Loan::factory()
        ->for($this->book)
        ->asOngoing()
        ->create();

    // The book should not be available, since there is a loan record for it...
    expect($this->book->isAvailable())
        ->toBeFalse();
});

it('can borrow a book for the given user', function () : void
{
    $user = User::factory()->create();

    // Borrow the book for the given user...
    $loan = $this->book->borrow($user->id);

    // Assert that the loan is ongoing for the given user...
    expect($loan)->toBeInstanceOf(Loan::class)
        ->and($loan->book_id)->toBe($this->book->id)
        ->and($loan->user_id)->toBe($user->id)
        ->and($loan->status)->toBe(LoanStatus::ONGOING);

    // Also assert that the database has the loan record...
    $this->assertDatabaseHas(table: Loan::getTableName(), data: [
        'book_id' => $this->book->id,
        'user_id' => $user->id,
        'status' => LoanStatus::ONGOING,
    ]);
});
