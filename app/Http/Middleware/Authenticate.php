<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Closure;


use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */


     public function handle(Request $request, Closure $next) {

        if(Auth::check()) {
          return $next($request);
        }
        
        return $this->redirectTo($request);
      
      }


    protected function redirectTo($request)
    {
        return redirect()->route('login'); 
    }
    
}
