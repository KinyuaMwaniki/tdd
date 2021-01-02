<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    // We make this test because the test_a_new_author_is_automatically_added test did not throw a good error so we drop down a level
    
    public function test_only_name_is_requried_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'John Doe',
        ]);

        $this->assertCount(1, Author::all());
    }
}
