<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/** @untested */
trait ApiResponses
{
    /**
     * Return a successful JSON response.
     */
    protected function ok(?string $message = '', mixed $data = [], int $statusCode = 200) : JsonResponse
    {
        return $this->success($message, $data, $statusCode);
    }

    /**
     * Customize the JSON response.
     */
    private function success(string $message = '', mixed $data = [], int $statusCode = 200) : JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ]);
    }

    /**
     * Return an error JSON response.
     */
    protected function error(string $message, int $statusCode) : JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }
}
