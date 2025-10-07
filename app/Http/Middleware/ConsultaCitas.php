<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConsultaCitas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tipos = ['telemedicina', 'whatsapp', 'firma'];

        if(!in_array($request->tipo, $tipos)){
            return response()->json('No ofresemos un servicio para este tipo de cita.', 401);
        }

        return $next($request);
    }
}
