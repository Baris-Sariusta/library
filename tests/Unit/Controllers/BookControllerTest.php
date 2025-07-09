<?php

declare(strict_types=1);

use App\Http\Requests\StoreBookRequest;
use App\Services\BookService;

beforeEach(function ()
{
    // Setup: Mocking of BookService, StoreBookRequest, user...
});

describe('retrieve a single book', function () : void
{
    todo('returns a single book when found');

    todo('returns 404 when book is not found');
});

describe('retrieve all books', function () : void
{
    todo('returns a paginated collection of books');

    todo('returns 404 when no books found (if applicable)');
});

describe('store a new book', function () : void
{
    todo('returns 201 with correct data when book is created successfully');

    todo('returns 403 when user is unauthorized to create a book');

    todo('returns correct structure and message on successful creation');
});
