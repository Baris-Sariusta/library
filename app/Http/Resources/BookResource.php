<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @untested */
final class BookResource extends JsonResource
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
                'average_rating' => $this->average_rating,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            //            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
