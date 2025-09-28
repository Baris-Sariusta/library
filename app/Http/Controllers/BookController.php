<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/** @untested-ignore */
final class BookController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        try
        {
            $books = Book::with(['author', 'genres'])->paginate(5);

            return $this->ok(
                message: 'Successfully retrieved books',
                data: BookResource::collection($books),
            );
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->error(message: $exception->getMessage(), statusCode: 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request, BookService $bookService) : JsonResponse
    {
        try
        {
            // Check if the user has permission to create a book...
            $this->authorize('create', Book::class);

            $book = $bookService->createBook(
                data: $request->validated(), // Pass only the validated fields to the service...
            );

            return $this->ok(
                message: 'Successfully added new book',
                data: new BookResource($book),
                statusCode: 201, // Status code should be 201, since a new resource is created...
            );
        }
        catch (AuthorizationException $exception)
        {
            return $this->error(message: $exception->getMessage(), statusCode: 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $book_id) : JsonResponse
    {
        try
        {
            $book = Book::with(['author', 'genres'])->findOrFail($book_id);

            return $this->ok(
                message: 'Successfully retrieved book',
                data: new BookResource($book),
            );
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->error('Book not found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
