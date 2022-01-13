<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        if (auth()->user() &&  auth()->user()->is_admin == 1) {
            return $next($request);
        }
        echo "<a href='".url('/')."'><h2>Home</h2></a><br>";
        return response("User can't perform this action. You need to be an Admin", 401);
    }
}
