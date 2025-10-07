<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = "KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY";
        if($request->token != $token){
            return response()->json('Tu token expiró.', 401);
        }
        return $next($request);
    }
}
