<?php

namespace App\Models;

use App\Contracts\PostContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Post extends Model implements PostContract
{
    use HasFactory;
    /**
     * The database table used by the model
     *
     * @var array
     **/
//    protected $table = "blog_posts";

    public $storage , $id;

    protected $fillable = ["id" ,"title","author","content"];

    public function __construct()
    {
        $this->storage = Redis::connection();

    }

    public function fetchAll()
    {
      // $seconds =  now()->addMinute(5);
        $result = Cache::remember('blog_posts_cache' ,1,function (){

           return $this->get();
        });
        return $result;
    }

    public function fetch($id)
    {
        $this->id = $id ;
        $this->storage->pipeline(function ($pipe)
        {
           $pipe->zIncrBy("articleViews" , 1 ,"article:".$this->id);
           $pipe->incr("article:".$this->id.":views");
        });
        return $this->where("id" , $this->id)->first();
    }

    public function getPostView($id)
    {
        return $this->storage->get("article:".$this->id.":views");
    }

    public function getViews()
    {
        // TODO: Implement getViews() method.
    }
}
