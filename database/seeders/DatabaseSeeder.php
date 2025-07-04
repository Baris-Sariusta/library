<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
          AuthorSeeder::class,
          GenreSeeder::class, // Seed genres first so books can attach them...
          BookSeeder::class,
          LoanSeeder::class,
          RatingSeeder::class,
          UserSeeder::class,
      ]);
    }
}
