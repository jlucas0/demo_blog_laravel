<?php

namespace App\Adapters;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidFieldException;
use Illuminate\Validation\Rule;
use App\Traits\ValidatesFields;

class PostAdapter implements Adapter{

    use ValidatesFields;

    /**
     * Default number of posts to be loaded
     */
    const DEFAULT_LIST_AMOUNT = 10;

    /**
     * Get a list of posts, by default 10.
     * @param int $amount Number of posts to be loaded. Set $amount to 0 to retrieve all posts.
     * @param int $offset Ignore $offset first posts.
     * @param string $orderField Name of the field to implements list ordenation
     * @param bool $ascending Sets ordenation ascending or descending
     * @return Collection List of found posts
     * @throws InvalidFieldException
     */
    public static function getList(int $amount = self::DEFAULT_LIST_AMOUNT, int $offset = 0, string $orderField = 'id', bool $ascending = true) : Collection{

        $results = new Collection;
        //Validate all parameters
        self::validateFields(
            [
                "amount" => $amount,
                "offset" => $offset,
                "orderField" => $orderField,
                "ascending" => $ascending,
            ],
            [
                "amount" => ["required","integer","min:0"],
                "offset" => ["required","integer","min:0"],
                "orderField" => ["required","string",Rule::in(\Schema::getColumnListing((new Post)->getTable()))],
                "ascending" => ["required","boolean"]
            ]
        );

        //Prepare the query
        $query = Post::query();

        $query->with('author');

        if($amount > 0){
            $query->limit($amount);
        }

        if($offset > 0){
            $query->offset($offset);
        }

        $query->orderBy($orderField, $ascending ? 'asc' : 'desc');

        //Get results
        try{
            $results = $query->get();
        }catch(\Exception $e){
            Log::error($e);
        }

        return $results;
    }

    /**
     * Find one post by id
     * @param int $id
     * @return Post|null Found model or null if not found
     */
    public static function findById(int $id) : Post|null{
        $post = null;

        try{
            $post = Post::with("author")->find($id);
        }catch(\Exception $e){
            Log::error($e);
        }

        return $post;
    }

    /**
     * Retrieves one post by it's slug
     * @param string $slug Unique slug of the post
     * @return Post|null Returns the found post or null
     */
    public static function findBySlug(string $slug) : Post|null{
        
        $post = null;

        //Check that slug is not empty
        self::validateFields(
            [
                "slug" => $slug,
            ],
            [
                "slug" => ["required","string"],
            ]
        );

        try{
            $post = Post::with('author')->where('slug',$slug)->first();
        }catch(\Exception $e){
            Log::error($e);
        }

        return $post;
    }

    /**
     * Creates a new post
     * @param array<mixed> $params Post needed parameters
     * @return bool|Post Created post or false
     */
    public static function create(array $params) : bool|Post{
        $result = false;

        //Validate all fields
        self::validateFields(
            $params,
            [
                "title" => ["required","string","max:100"],
                "slug" => ["required","string","max:100","unique:posts,slug"],
                "post" => ["required","string"],
                "extract" => ["required","string","max:200"],
                "author_id" => ["required","integer","exists:authors,id"]
            ]
        );
        
        $post = new Post();
        //Type verification applied to ensure that types are exact what expected in Post Class, so PHPStan not fails because $params are considered as mixed, but at this point type are ensured by validation
        $post->title = (gettype($params["title"]) == "string" ? $params["title"] : "");
        $post->slug = (gettype($params["slug"]) == "string" ? $params["slug"] : "");
        $post->post = (gettype($params["post"]) == "string" ? $params["post"] : "");
        $post->extract = (gettype($params["extract"]) == "string" ? $params["extract"] : "");
        $post->author_id = (is_numeric($params["author_id"]) ? (int)$params["author_id"] : 0);

        try{
            $post->save();
            $result = $post;
        }catch(\Exception $e){
            Log::error($e);
        }

        return $result;
    }

    /**
     * Get amount of registered posts
     * @return int Number of existing posts, -1 if fails
     */
    public static function getCount() : int{
        $count = -1;
        try{
            $count = Post::count();
        }catch(\Exception $e){
            Log::error($e);
        }
        return $count;
    }
}