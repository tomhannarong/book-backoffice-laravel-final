<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class XSS
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
        $input = $request->all();
        // DD($input);
        array_walk_recursive($input, function(&$input) {
            // $input = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input); 
            // DD($input);
            $input = preg_replace('#<script(.*?)>(.*?)</script>#is', '', html_entity_decode($input));

            
            // $input = strip_tags($input);
            // DD($input);
            // echo "<script>sonsole.log('123');</script>";
           
        });
        // $input = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
        $request->merge($input);
        return $next($request);
    }
}
