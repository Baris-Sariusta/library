<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @untested-ignore */
final class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            'type' => 'loan',
            'id' => $this->id,
            'attributes' => [
                'book_id' => $this->book_id,
                'user_id' => $this->user_id,
                'loan_date' => $this->loan_date,
                'return_date' => $this->return_date,
                'status' => $this->status,
            ],
        ];
    }
}
