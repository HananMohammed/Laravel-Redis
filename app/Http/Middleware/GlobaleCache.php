<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GlobaleCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header("Cache-Clear" , "maxAge=86400") ;
        return $response;
    }
}
