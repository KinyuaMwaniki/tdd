<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;

class BooksController extends Controller
{
    public function store(BookRequest $request)
    {
        Book::create($request->all());
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->all());
    }
}
