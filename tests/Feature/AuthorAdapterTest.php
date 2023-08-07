<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Adapters\AuthorAdapter;
use Illuminate\Support\Facades\Artisan;
use App\Models\Author;

class AuthorAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_by_id(): void{
        //Run migrations
        Artisan::call('migrate:fresh');
        Author::factory(1)->create();

        //Not existing id
        $this->assertNull(AuthorAdapter::findById(2));
        //Valid id
        $author = AuthorAdapter::findById(1);
        $this->assertNotNull($author);
        $this->assertInstanceOf(Author::class,$author);
    }
}
