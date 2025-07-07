<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\loginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

/** @untested */
final class AuthController extends ApiController
{
    use ApiResponses;

    /**
     * Log in the user.
     */
    public function login(LoginUserRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password')))
        {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request['email']);

        return $this->ok(
            message: "Hello, {$user->username}",
            data: [
                'token' => $user->createToken("API token for {$user['email']}")->plainTextToken,
            ],
        );
    }
}
