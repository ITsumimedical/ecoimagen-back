<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuditoriaDeUso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Storage::append('logs_uso_ruta.txt', json_encode([
            'ip' => $request->ip(),
            'uri' => $request->path(),
            'datos' => $request->all(),
            'fecha_hora' => now(),
            'metodo' => $request->method(),
            'headers' => $request->headers->all()
        ]));
        
        return $next($request);
    }
}
