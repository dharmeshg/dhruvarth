<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebApplicationFirewall
{
    // Define patterns to detect malicious inputs
    protected $patterns = [
        '/<script\b[^>]*>(.*?)<\/script>/is', // XSS
        '/select\b.*\bfrom\b/i', // SQL Injection
        '/union\b.*\bselect\b/i', // SQL Injection
        '/insert\b.*\binto\b/i', // SQL Injection
        '/update\b.*\bset\b/i', // SQL Injection
        '/delete\b.*\bfrom\b/i', // SQL Injection
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($request->all() as $key => $value) {
            if ($this->containsMaliciousContent($value)) {
                return response()->json(['message' => 'Request contains forbidden content'], 403);
            }
        }

        return $next($request);
    }

    /**
     * Recursively check if the value contains malicious content.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function containsMaliciousContent($value)
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->containsMaliciousContent($item)) {
                    return true;
                }
            }
        } elseif (is_string($value)) {
            foreach ($this->patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    return true;
                }
            }
        }

        return false;
    }
}
