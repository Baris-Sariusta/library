<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

final class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Rating::factory()->count(35)->create();
    }
}
