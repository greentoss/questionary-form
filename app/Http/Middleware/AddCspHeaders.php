<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCspHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Allow Vite's development server and unsafe-inline for scripts
        $response->headers->set(
            'Content-Security-Policy',
            "script-src 'self' 'unsafe-inline' http://localhost:5173; " .
            "style-src 'self' 'unsafe-inline' http://localhost:5173; " .
            "style-src-elem 'self' http://localhost:5173;"
        );

        return $response;
    }
}

