<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

final class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Author::factory()->count(35)->create();
    }
}
