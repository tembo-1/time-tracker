<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     *
     */
    public function handle(Request $request, Closure $next)
    {
        return (auth()->user()->role->name === 'Manager') ? $next($request) : redirect('/');
    }
}
