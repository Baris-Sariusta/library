<?php

namespace Database\Factories;

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
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'published_at' => $this->faker->date(),
            'genre' => $this->faker->randomElement([
                'Science Fiction',
                'Fantasy',
                'Thriller',
                'Mystery',
                'Romance'
            ]),
            'language' => $this->faker->languageCode(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'publisher' => $this->faker->company(),
            'rating' => $this->faker->numberBetween(1, 5),
            'cover_image' => null,
        ];
    }
}
