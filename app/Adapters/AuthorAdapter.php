<?php

namespace App\Adapters;

use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
     * Performs login with given author
     * @param string $email
     * @param string $password Plain text password
     * @param bool $token Specifies if should generate an api token or not
     * @return boolean|string Indicates if login was successful. If token is requested, returns it on success login.
     */
    public static function login(string $email, string $password, bool $token = false) : bool|string{
        $success = false;
        $author = null;
        $generatedToken = "";

        try{
            $author = Author::where("email",$email)->first();
            if(!empty($author)){
                if(Hash::check($password,$author->password)){
                    if($token){
                        $author->tokens()->delete();
                        $generatedToken = $author->createToken("api");
                        $success = $generatedToken->plainTextToken;
                    }else{
                        session()->regenerate();
                        Auth::login($author);
                        $success = true;
                    }
                }
            }
        }catch(\Exception $e){
            Log::error($e);
        }

        return $success;
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