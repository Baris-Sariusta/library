<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => self::$password ??= Hash::make('password'),
            'role' => $this->faker->randomElement(['member', 'librarian', 'manager']),
            'admin' => false,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified() : static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate what the user role is.
     */
    public function withRole(UserRole $role) : self
    {
        return $this->state(fn () : array => [
            'role' => $role,
        ]);
    }

    /**
     * Indicate what the model's email address is.
     */
    public function withEmail(string $email) : self
    {
        return $this->state(fn () : array => [
            'email' => $email,
        ]);
    }

    /**
     * Indicate that the user role is 'member'.
     */
    public function asMember() : self
    {
        return $this->state(fn () : array => [
            'role' => UserRole::MEMBER,
        ]);
    }

    /**
     * Indicate that the user role is 'librarian'.
     */
    public function asLibrarian() : self
    {
        return $this->state(fn () : array => [
            'role' => UserRole::LIBRARIAN,
        ]);
    }

    /**
     * Indicate that the user role is 'manager'.
     */
    public function asManager() : self
    {
        return $this->state(fn () : array => [
            'role' => UserRole::MANAGER,
        ]);
    }

    /**
     * Indicate that the User is an admin.
     */
    public function asAdmin() : self
    {
        return $this->state(fn () : array => [
            'admin' => true,
        ]);
    }
}
