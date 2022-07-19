<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        // return $next($request);
        
        $user = auth()->user();
        $user_roles = $user->getUserRole()->name;

        if($user_roles=="admin"){
            return $next($request);
        }
 
        return redirect('/')->withError("You don't have Admin Access");
    }
}
