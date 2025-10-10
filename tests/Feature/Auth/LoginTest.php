<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('fails to log in if a user is already authenticated', function ()
{
    $user = User::factory()->create();

    // Make sure the user is authenticated...
    Sanctum::actingAs($user);

    // Create a login attempt with the already authenticated user...
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // Make sure an error is returned...
    $response->assertStatus(409)
        ->assertJson(['message' => 'You are already logged in.']);
});
