<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest");
    }

    public function blogArticle($id)
    {
        $this->id = $id ;
        $storage = Redis::connection() ;
        if ($storage->zScore("articleViews" , "article:".$id))
        {
            //Pipelining should be used when you need to send many commands to the server.
            $storage->pipeline(function ($pipe){

                $pipe->zIncrBy("articleViews" ,1, "article:". $this->id );

                $pipe->incr("article:" . $this->id . ":views") ;

            });
        }
        else
        {
            $views = $storage->incr("article:" . $this->id . ":views") ;

            $storage->zIncrBy("articleViews" ,$views, "article:". $this->id );
        }

        $views = $storage->get("article:" . $this->id . ":views") ;

        return "This is an article with id: ".$this->id ."it has " . $views ."views"."Largest Article Views";
    }
}
