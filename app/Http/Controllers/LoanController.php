<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Requests\Loan\UpdateLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\JsonResponse;

/** @untested-ignore */
final class LoanController extends ApiController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly LoanService $loanService,
    ) {}

    /**
     * Store a record of a new loan.
     */
    public function store(StoreLoanRequest $request) : JsonResponse
    {
        $loan = $this->loanService->borrowBook(
            data: $request->validated(), // Pass only the validated fields to the service...
            user: $request->user(),
        );

        return $this->ok(
            message: 'Succesfully added new loan',
            data: new LoanResource($loan),
            statusCode: 201, // Status code should be 201, since a new resource is created...
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, Loan $loan) : JsonResponse
    {
        $this->loanService->returnBook($loan);

        return $this->ok(
            message: 'Succesfully returned loan',
            data: new LoanResource($loan),
        );
    }
}
