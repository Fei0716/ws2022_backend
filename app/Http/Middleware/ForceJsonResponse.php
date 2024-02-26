<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // to put in header = 'Accept' => 'application/json' for every api request
        // or else laravel sanctum wont work properly
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
