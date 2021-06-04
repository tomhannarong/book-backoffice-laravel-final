<?php

namespace App\Http\Middleware;

use Closure;

class IsPub
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
        if(auth()->user()->class_user == "admin" || auth()->user()->class_user == "pub" || auth()->user()->class_user == "writer"){
            if(auth()->user()->approve_consignment = 'approved'){
                return $next($request);
            }
            
        }
  
        return redirect('/')->with('error',"You cannot access.");
    }
}
