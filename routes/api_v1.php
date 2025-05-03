<?php

use App\Http\Controllers\Api\V1\BookController;

//Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('books', BookController::class);
//});
