<?php

declare(strict_types=1);

namespace App\Http\Requests\Loan;

use App\Rules\BookMatchesLoan;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        // Ensure that the loan belongs to the user of this request...
        return $this->route('loan')->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        // Retrieve the loan model from the current route...
        // Type hint the variable so the IDE recognizes the model...
        $loan = $this->route('loan'); /** @var \App\Models\Loan $loan */

        return [
            'book_id' => [
                'required',
                new BookMatchesLoan($loan),
            ],
        ];
    }
}
