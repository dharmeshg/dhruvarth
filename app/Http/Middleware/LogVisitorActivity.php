<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use Shetabit\Visitor\Facades\Visitor;
use App\Models\Loginactivity;

class LogVisitorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Visitor::capture();
        // $logActivity = new Loginactivity();
        // $logActivity->ip_address = $request->ip();
        // $logActivity->user_agent = $request->header('User-Agent');
        // $logActivity->url = $request->fullUrl();
        // $logActivity->visited_at = now(); 

        // $logActivity->save();
        return $next($request);
    }
}
