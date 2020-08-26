<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        if (Auth::check()){
            if (Auth::user()->listRoles()->contains('admin'))
            {
                return $next($request);
            } else {
                return redirect(route(('home')));
            }
        } else {
            return redirect(route(('home')));
        }
    }
}
