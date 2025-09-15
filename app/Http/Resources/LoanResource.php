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
            'type' => 'book',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
            ],
        ];
    }
}
