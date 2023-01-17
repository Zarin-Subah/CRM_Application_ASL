<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if (Auth::check() && Auth::user()->role == 'title_officer') {
            return $next($request);
        }
        abort(403);
    }
}   