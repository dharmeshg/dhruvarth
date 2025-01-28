<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerRole
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has the role of a customer
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request); // Allow access to the route
        }

        return redirect()->route('home'); // Redirect to the home route
    }
}
