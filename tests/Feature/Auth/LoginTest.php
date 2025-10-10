<?php

declare(strict_types=1);

use App\Models\User;

it('fails to log in if a user is already authenticated', function ()
{
    $user = User::factory()->create();

    // Make sure the user is authenticated...
    $token = $user->createToken('API token')->plainTextToken;

    // Make a login attempt with the authenticated user...
    $response = $this
        ->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

    // Make sure the request is blocked, since the user is already authenticated...
    $response->assertStatus(409)
        ->assertJson(['message' => 'You are already logged in.']);
});
