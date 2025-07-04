<?php

declare(strict_types=1);

use App\Models\Book;

it('book should contain a genre', function (): void {
    Book::factory()->count(1)->create();

    dd(Book::all());

    expect()
        ->pluck('genre')
        ->toBe([
            'Fiction',
        ]);
});
