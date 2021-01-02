<?php

namespace Tests\Feature;

use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    // Refresh database migrates and tears down the database after each single test
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();
            
        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    function test_a_title_is_required()
    {
            
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Felix Mwaniki'
        ]);

        $response->assertSessionHasErrors();
    }

    function test_an_author_is_required()
    {
            
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }


    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling(); 

        $this->post('/books', $this->data());
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books/');
    }

    // This is here because it we will hit the end point of books.
    public function test_a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author_id' => 'Felix Mwaniki'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Felix Mwaniki'
        ];
    }

}
