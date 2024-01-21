<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeaderAccept
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->headers->get('Accept') != 'application/json' and strpos($request->header('user-agent'),'PostmanRuntime') !== false) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
