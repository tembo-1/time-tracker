<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->headers->get('Cache-Control') != 'no-cache, no-store, must-revalidate') {
            $request->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        return $next($request);
    }
}
