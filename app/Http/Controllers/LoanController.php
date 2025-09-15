<?php

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\BorrowLoanRequest;
use App\Http\Requests\ReturnLoanRequest;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * Borrow a book.
     */
    public function borrow(BorrowLoanRequest $request, $bookId)
    {
        //
    }

    /**
     * Return a book.
     */
    public function return(Request $request, $bookId)
    {
        //
    }
}
