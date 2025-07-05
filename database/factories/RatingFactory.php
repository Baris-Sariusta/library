<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
final class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'score' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->paragraph(),
        ];
    }

    /**
     * Set a custom comment, or use a random comment if none given.
     */
    public function withComment(?string $comment = null) : self
    {
        return $this->state(fn () : array => [
            'comment' => $comment ?? $this->faker->paragraph(),
        ]);
    }
}
