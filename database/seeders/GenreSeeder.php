<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Science Fiction',
            'Fantasy',
            'Thriller',
            'Mystery',
            'Romance',
            'Biography',
            'Non-fiction',
            'Fiction',
        ];

        // Ensure each genre is created only once in the table...
        foreach ($genres as $genre) {
            Genre::query()->create(['title' => $genre]);
        }
    }
}
