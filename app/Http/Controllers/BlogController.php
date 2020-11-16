<?php

namespace App\Http\Controllers;

use App\Contracts\PostContract;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    public $post ;

    public function __construct(PostContract $post)
    {
        $this->post = $post ;
        $this->middleware("guest") ;
    }

    /**
     *Show Main blog with Posts
     *
     * @return Response
     */
    public function showBlog()
    {
         $posts = $this->post->fetchAll();
         $tags = Redis::isRandMember("article:tags" , 4) ;
       return view('home')->with(["posts" =>$posts , "tags" => $tags]);
    }

    /**
     * @param $id integer article view
     * @return string number of article Views
     */
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
