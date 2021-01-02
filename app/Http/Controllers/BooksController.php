<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;

class BooksController extends Controller
{
    public function store(BookRequest $request)
    {
        $book = Book::create($request->all());
        return redirect($book->path());
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->all());
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}
