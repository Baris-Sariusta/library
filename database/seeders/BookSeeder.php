<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

final class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Book::factory()
            ->count(50)
            ->create()

            // Attach 1 to 3 random genres to each book...
            ->each(function ($book)
            {
                $genres = Genre::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');
                $book->genres()->attach($genres);
            });
    }
}
