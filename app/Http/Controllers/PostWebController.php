<?php

namespace App\Http\Controllers;

use App\Adapters\PostAdapter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class PostWebController extends Controller
{

    /**
     * Shows home view with list of posts
     * @param Request $request Request object
     * @return View
     */
    public function home(Request $request) : View{

        $page = $request->page ?? 1;
        
        $offset = 0;

        //Calculates the offset
        if(is_numeric($page) && $page > 1){
            $page = (int)$page;
            $offset = ($page - 1) * PostAdapter::DEFAULT_LIST_AMOUNT;
        }

        //Get results ordered by its create date and considering current pagination
        $results = PostAdapter::getList(PostAdapter::DEFAULT_LIST_AMOUNT,$offset,'created_at',false);

        return view('posts.list',["posts" => $results,"page"=>$page]);
    }

    /**
     * Loads post info by given slug
     * @param string $slug Post's unique slug
     * @return View
     */
    public function post(string $slug) : View{
        return view('posts.post');
    }
}
