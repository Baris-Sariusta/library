<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ApiController;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/** @untested */
final class BookController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse|AnonymousResourceCollection
    {
        try
        {
            $books = Book::with('author')->paginate(5);

            return BookResource::collection($books);
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->error($exception->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try
        {
            dd($request->user);
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->error($exception->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string|int $book_id) : JsonResponse|BookResource
    {
        try
        {
            return new BookResource(Book::findOrFail($book_id));
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
