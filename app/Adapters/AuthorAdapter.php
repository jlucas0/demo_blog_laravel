<?php

namespace App\Adapters;

use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class AuthorAdapter implements Adapter{
    
    /**
     * Get all registered authors
     * @return Collection
     */
    public static function getList() : Collection{
        $collection = new Collection;

        try{
            $collection = Author::all();
        }catch(\Exception $e){
            Log::error($e);
        }

        return $collection;
    }

    /**
     * Find one author by id
     * @param int $id
     * @return Author|null Found model or null if not found
     */
    public static function findById(int $id) : Author|null{
        $author = null;

        try{
            $author = Author::find($id);
        }catch(\Exception $e){
            Log::error($e);
        }

        return $author;
    }

    /**
     * Not implemented yet
     * @param array<mixed> $params
     * @return bool|Author
     */
    public static function create(array $params) : bool|Author{
        return false;
    }

    /**
     * Get number of registered authors
     * @return int
     */
    public static function getCount() : int{
        $count = -1;
        try{
            $count = Author::count();
        }catch(\Exception $e){
            Log::error($e);
        }
        return $count;
    }
}