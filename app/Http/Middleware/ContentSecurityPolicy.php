<?php

namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Production CSP Policy
        $response->headers->set('Content-Security-Policy', "
            default-src 'self'; 
            script-src 'self'; 
            style-src 'self'; 
            img-src 'self' data:;
        ");

        return $response;
    }
}
