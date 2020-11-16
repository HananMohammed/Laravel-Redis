<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
//Route::group(["middleware" => "cache"] , function (){
//    Route::get('/', function () {
//        $redis = app()->make('redis') ;
//        $redis->set("key1" , "Hello From Other Side ") ;
//        return  dd($redis->get("key1"));
//    });
//});
Route::get("/" ,"WelcomeController@index");
Route::get("/article/{id}" ,"BlogController@blogArticle")->where("id" ,"[0-9]+" );
Route::get("/blog" ,"BlogController@showBlog");
