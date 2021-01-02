<?php

namespace Tests\Unit;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BookTest extends TestCase
{

    use RefreshDatabase;

    public function test_an_author_id_is_recorded()
    {

        // Creating at the root without going to roots

        Book::create([
            'title' => 'Cool Title',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
