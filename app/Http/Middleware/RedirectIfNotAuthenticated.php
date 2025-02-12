<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
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
        // Skip redirecting if the user is already on the login route
        if (!Auth::check() && (!$request->is('login') && $request->is('/signin'))) {
            // Redirect to the login page if the user is not logged in
            return redirect()->route('login');
        }

        // Allow the request to continue if authenticated
        return $next($request);
    }
}
