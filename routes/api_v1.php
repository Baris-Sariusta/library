<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\BookController;

// Route::middleware('auth:sanctum')->group(function() {
Route::apiResource('books', BookController::class);
// });
