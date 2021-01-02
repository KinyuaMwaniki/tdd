<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    // Refresh database migrates and tears down the database after each single test
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();
            
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Felix Mwaniki'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        // $response->assertResponse(302);
        $response->assertRedirect($book->path());
    }

    function test_a_title_is_required()
    {
        // $this->withoutExceptionHandling();
            
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Felix Mwaniki'
        ]);

        $response->assertSessionHasErrors();
    }

    function test_an_author_is_required()
    {
        // $this->withoutExceptionHandling();
            
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors();
    }

    function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Felix Mwaniki'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }


    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling(); 

        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Felix Mwaniki'
        ]);
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books/');
    }

}
