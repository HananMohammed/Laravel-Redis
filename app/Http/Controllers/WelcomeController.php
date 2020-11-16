<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest");
    }

    public function index()
    {
        $storage = Redis::connection() ;

        $populars = $storage->zRevRange("articleViews" ,0 ,-1);

        foreach($populars as $popular)
        {
            $id = str_replace("article:" ,"" ,$popular);

            echo "Article " .$id . "is The Most Popular"."<br>";
        }

    }
}
