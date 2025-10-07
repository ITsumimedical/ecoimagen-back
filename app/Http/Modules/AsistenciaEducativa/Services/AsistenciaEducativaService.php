<?php

namespace App\Http\Modules\AsistenciaEducativa\Services;

use App\Http\Modules\AsistenciaEducativa\Models\AsistenciaEducativa;
use App\Http\Modules\AsistenciaEducativa\Repositories\AsistenciaEducativaRepository;
use Illuminate\Support\Facades\Auth;

class AsistenciaEducativaService
{

    public function __construct(protected AsistenciaEducativaRepository $asistenciaEducativaRepository)
    {
    }

    public function crearAsistencia($request)
    {
        $nuevaAsistencia = new AsistenciaEducativa();
        $nuevaAsistencia->fecha = $request['fecha'];
        $nuevaAsistencia->ambito = 1;
        $nuevaAsistencia->finalidad = 4;
        $nuevaAsistencia->tema = $request['tema'];
        $nuevaAsistencia->cup_id = $request['tipo_educacion'];
        $nuevaAsistencia->usuario_registra_id = auth()->user()->id;
        $nuevaAsistencia->afiliado_id = $request['afiliado_id'];
        $nuevaAsistencia->save();
    }
}
