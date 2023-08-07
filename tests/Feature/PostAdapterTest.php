<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Adapters\PostAdapter;
use App\Models\Author;
use Illuminate\Support\Facades\Artisan;


class PostAdapterTest extends TestCase
{
    public function test_list_invalid_amount(): void{
        $this->expectException(\App\Exceptions\InvalidFieldException::class);
        PostAdapter::getList(-1);
    }
    public function test_list_invalid_offset(): void{
        $this->expectException(\App\Exceptions\InvalidFieldException::class);
        PostAdapter::getList(5,-1);
    }
    public function test_list_invalid_order_field(): void{
        $this->expectException(\App\Exceptions\InvalidFieldException::class);
        PostAdapter::getList(5,0,"invalid_field");
    }

    public function test_count_number_of_post(): void{
        //Run migrations
        Artisan::call('migrate:fresh');

        //Empty posts
        $this->assertEquals(0,PostAdapter::getCount());

        //Create 10 posts
        Author::factory(1)->hasPosts(10)->create();

        //Counts 10
        $this->assertEquals(10,PostAdapter::getCount());
    }

    public function test_list_with_valid_parameters(): void{

        //Run migrations
        Artisan::call('migrate:fresh');

        //Empty results
        $result = PostAdapter::getList();

        $this->assertCount(0,$result);

        //Run seeders
        Artisan::call('db:seed');

        //Exact amount
        $result = PostAdapter::getList(20);

        $this->assertCount(20,$result);

        //With offset (starting id like offset + 1)
        $result = PostAdapter::getList(10,5);

        $this->assertEquals(6,$result[0]->id);

        //Change order field
        $result = PostAdapter::getList(10,0,'slug');

        $this->assertGreaterThan($result[0]->slug,$result[1]->slug);

        //Change direction
        $result = PostAdapter::getList(10,0,'slug',false);
        $this->assertGreaterThan($result[1]->slug,$result[0]->slug);

        //Full list
        $result = PostAdapter::getList(0);
        $this->assertCount(PostAdapter::getCount(),$result);
    }

    public function test_find_with_invalid_slug(): void{
        $this->expectException(\App\Exceptions\InvalidFieldException::class);
        PostAdapter::findBySlug("");
    }

    public function test_find_by_slug(): void{
        //Not existing slug
        $this->assertNull(PostAdapter::findBySlug("not-exists"));

        //Run migrations
        Artisan::call('migrate:fresh');
        //Create 1 post
        Author::factory(1)->hasPosts(1,['slug' => "valid-slug"])->create();

        //Existing slug
        $post = PostAdapter::findBySlug("valid-slug");
        $this->assertInstanceOf(\App\Models\Post::class,$post);
    }
}
