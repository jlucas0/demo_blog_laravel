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

    public function test_login(): void{
        //Run migrations
        Artisan::call('migrate:fresh');

        //Not found email
        $this->assertFalse(AuthorAdapter::login("fake","1234"));

        //Create Author
        $author = new Author();
        $author->name = "Testing Author";
        $author->email = "fake@author.es";
        $author->password = \Illuminate\Support\Facades\Hash::make("12345");
        $author->save();

        //Invalid password
        $this->assertFalse(AuthorAdapter::login("fake@author.es","54321"));

        //Success login with session
        $this->assertTrue(AuthorAdapter::login("fake@author.es","12345"));
        $this->assertTrue(\Illuminate\Support\Facades\Auth::check());
        
        //Success login with token
        $this->assertIsString(AuthorAdapter::login("fake@author.es","12345",true));
        $this->assertCount(1,$author->tokens()->get());
    }
}
