<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCspHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Content-Security-Policy',
            "style-src 'self' http://localhost:5173 'unsafe-inline'; script-src 'self' http://localhost:5173; font-src 'self';"
        );

        return $response;
    }
}
