<?php

declare(strict_types=1);

namespace App\Http\Requests\Loan;

use App\Rules\BookMatchesLoan;
use Illuminate\Foundation\Http\FormRequest;

/** @tested */
final class UpdateLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return $this->user()->can('update', $this->route('loan'));
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
