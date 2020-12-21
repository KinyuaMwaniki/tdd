<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
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

        $this->assertCount(1, Book::all());
        $response->assertOk();
    }
}
