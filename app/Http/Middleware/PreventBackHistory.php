<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBackHistory {
    public function handle(Request $request, Closure $next) {
        $response = $next($request);

        // Prevent caching of protected pages
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        // Prevent authenticated users from accessing login/register pages
        if (Auth::check() && ($request->is('login'))) {
            return redirect()->route('index'); // Adjust the route to your dashboard
        }

        // Prevent unauthenticated users from accessing protected pages
        if (!Auth::check() && $request->is('dashboard')) {
            return redirect()->route('login'); // Adjust the route to your login page
        }

        return $response;
    }
}
