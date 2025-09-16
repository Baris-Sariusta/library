<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\BorrowLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Services\LoanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

final class LoanController extends ApiController
{
    /**
     * Borrow a book.
     */
    public function borrow(BorrowLoanRequest $request, Book $book, LoanService $loanService)
    {
        try
        {
            $loan = $loanService->borrowBook(
                book: $book,
                user: $request->user(),
            );

            return $this->ok(
                message: 'Book successfully borrowed',
                data: new LoanResource($loan),
                statusCode: 201,
            );
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->error('Book not found', 404);
        }
    }

    /**
     * Return a book.
     */
    public function return(Request $request, $bookId)
    {
        //
    }
}
