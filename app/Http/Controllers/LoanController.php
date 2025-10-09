<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/** @untested-ignore */
final class LoanController extends ApiController
{
    /**
     * Store a record of a new loan.
     */
    public function store(StoreLoanRequest $request, LoanService $loanService) : JsonResponse
    {
        try
        {
            $loan = $loanService->borrowBook(
                data: $request->validated(), // Pass only the validated fields to the service...
                user: $request->user(),
            );

            return $this->ok(
                message: 'Succesfully added new loan',
                data: new LoanResource($loan),
                statusCode: 201, // Status code should be 201, since a new resource is created...
            );
        }
        catch (ValidationException $exception)
        {
            return $this->error(message: $exception->getMessage(), statusCode: 422); // 422: Request is invalid for existing business rules...
        }
    }
}
