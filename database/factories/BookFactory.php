<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
final class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
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

    /**
     * Define fixed values for scenarios where this is needed.
     */
    public function withStaticValues() : self
    {
        return $this->state(fn () : array => [
            'title' => 'foo',
            'description' => 'bar',
            'average_rating' => 5,
            'published_at' => '2025-01-01',
            'language' => 'baz',
            'price' => 10.00,
            'publisher' => 'bax',
            'cover_image' => 'fop',
        ]);
    }

    /**
     * Indicate what the title is.
     */
    public function withTitle(string $title) : self
    {
        return $this->state(fn () : array => [
            'title' => $title,
        ]);
    }
}
