<?php

namespace App\Http\Middleware;

use Closure;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->class_user == "admin" || auth()->user()->class_user == "pub" || auth()->user()->class_user == "user" || auth()->user()->class_user == "writer"){
            return $next($request);
        }
  
        return redirect('/')->with('error',"You don't have user access.");
    }
}
