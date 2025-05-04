<?php

namespace App\Traits;

trait ApiResponses {
    protected function ok($message, $data = []) : string {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data = [], $statusCode = 200) : string {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }

    protected function error($message, $statusCode) : string {
        return response()->json([
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }
}
