<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RegistroUserActividad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        # verificamos que el usuario este logueado
        if (Auth::check()) {
            Redis::setex('laravel_cache_:usuarios-activos:' . Auth::id(), 1200, now()->toDateString());
        }
        return $next($request);
    }
}
