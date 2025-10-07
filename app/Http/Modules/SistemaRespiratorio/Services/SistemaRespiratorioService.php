<?php

namespace App\Http\Modules\SistemaRespiratorio\Services;

use App\Http\Modules\SistemaRespiratorio\Models\SistemasRespiratorios;
use Illuminate\Support\Facades\Auth;

class SistemaRespiratorioService
{
    public function crearSistemaRespiratorio($request)
    {
        $sistemaRespiratorio = SistemasRespiratorios::updateOrCreate([
            'consulta_id' => $request['consulta_id'],
            'creado_por' => Auth::id(),
        ],$request);

        return $sistemaRespiratorio;
    }
}
