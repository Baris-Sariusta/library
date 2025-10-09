<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @untested-ignore */
final class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            'type' => 'author',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'bio' => $this->bio,
                'birth_date' => $this->birth_date,
            ],
        ];
    }
}
