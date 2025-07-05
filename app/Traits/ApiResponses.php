<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/** @untested */
trait ApiResponses
{
    protected function ok($message, $data = []) : JsonResponse
    {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data = [], $statusCode = 200) : JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function error($message, $statusCode) : JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }
}
