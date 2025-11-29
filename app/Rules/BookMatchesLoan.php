<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Loan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** @tested */
final class BookMatchesLoan implements ValidationRule
{
    /**
     * Create a new rule instance.
     */
    public function __construct(
        private readonly Loan $loan,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        // Ensure that the given book_id matches the book_id of the loan...
        if ((int) $value !== $this->loan->book_id)
        {
            $fail('The given book id does not match this loan.');
        }
    }
}
