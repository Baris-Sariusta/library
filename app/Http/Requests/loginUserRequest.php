<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Sanctum\PersonalAccessToken;

/** @untested */
final class loginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        // Determine if there is an allowed token...
        if ($this->bearerToken())
        {
            $activeToken = PersonalAccessToken::findToken($this->bearerToken());

            if ($activeToken)
            {
                throw new HttpResponseException(response()->json([
                    'message' => 'You are already logged in.',
                ], status: 409));
            }
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|max:20',
        ];
    }
}
