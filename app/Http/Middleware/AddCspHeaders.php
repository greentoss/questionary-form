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
            "script-src 'self' 'unsafe-inline' http://localhost:5173 'wasm-unsafe-eval' 'inline-speculation-rules'; style-src 'self' 'unsafe-inline' http://localhost:5173;"
        );

        return $response;
    }
}
