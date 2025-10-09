<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\ApiResponses;
use App\Http\Requests\loginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** @untested-ignore */
final class AuthController extends ApiController
{
    use ApiResponses;

    /**
     * Log the user in.
     */
    public function login(LoginUserRequest $request) : JsonResponse
    {
        // Check if login credentials are valid...
        if (! Auth::attempt($request->only(keys: ['email', 'password'])))
        {
            return $this->error(message: 'Invalid credentials', statusCode: 401);
        }

        $user = User::firstWhere('email', $request['email']);

        // Don't send a token if the user is already logged in...
        // ..

        return $this->ok(
            message: "Hello, {$user->username}",
            data: ['token' => $user->generateApiToken()],
        );
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request) : JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok(message: "Logged out {$request->user()->username}");
    }
}
