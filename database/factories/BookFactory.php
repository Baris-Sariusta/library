<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author_id' => Author::factory(),
            'description' => $this->faker->paragraph(),
            'published_at' => $this->faker->date(),
            'language' => $this->faker->languageCode(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'publisher' => $this->faker->company(),
            'average_rating' => $this->faker->numberBetween(1, 5),
            'cover_image' => $this->faker->imageUrl(),
        ];
    }
}
