<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
final class LoanFactory extends Factory
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
            'loan_date' => $this->faker->date(),
            'return_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(LoanStatus::cases()),
        ];
    }

    /**
     * Set a custom return_date, or use a random date if none given.
     */
    public function withReturnDate(?string $date = null) : self
    {
        return $this->state(fn () : array => [
            'return_date' => $date ?? $this->faker->date(),
        ]);
    }

    /**
     * Indicate that the loan status is ongoing.
     */
    public function asOngoing() : self
    {
        return $this->state(fn () : array => [
            'status' => LoanStatus::ONGOING,
        ]);
    }
}
