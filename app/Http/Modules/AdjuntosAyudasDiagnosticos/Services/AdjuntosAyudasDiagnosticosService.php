<?php

namespace App\Http\Modules\AdjuntosAyudasDiagnosticos\Services;

use App\Http\Modules\AdjuntosAyudasDiagnosticos\Models\AdjuntosAyudasDiagnosticos;

class AdjuntosAyudasDiagnosticosService
{
    public function crearAdjunto($request)
    {
        $adjunto = AdjuntosAyudasDiagnosticos::create([
            'nombre' => $request['nombre'],
            'ruta' => $request['ruta'],
            'resultado_ayudas_diagnosticas_id' => $request['resultado_ayudas_diagnosticas_id']
        ]);

        return $adjunto;
    }
}
