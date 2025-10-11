<?php

declare(strict_types=1);

namespace App\Http\Requests\Book;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

/** @untested */
final class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        // Ensure that the user has permission to create a book...
        return $this->user()->can('create', Book::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:books,title'],
            'description' => ['nullable', 'string'],
            'author_id' => ['required', 'exists:authors,id'],
            'genre_ids' => ['required', 'array'],
            'genre_ids.*' => ['exists:genres,id'], // Check if the individual elements are present in the genres table...
            'published_at' => ['nullable', 'date', 'before_or_equal:today'],
            'language' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ];
    }
}
