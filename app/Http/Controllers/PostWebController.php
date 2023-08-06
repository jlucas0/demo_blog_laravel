<?php

namespace App\Http\Controllers;

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

        return view('posts.list');
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
