<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(\App\Http\Controllers\AuthorApiController::class)->prefix('author')->group(function(){

    // Route::put('/login','login');
    // Route::get('/{id}','findById');

});

Route::controller(\App\Http\Controllers\PostApiController::class)->prefix('post')->group(function(){

    // Route::get('/list','list');
    // Route::middleware('auth:sanctum')->post('/create','create');
    // Route::get('/{id}','findById');

});
