<?php

namespace App\Http\Modules\PatologiaRespiratoria\Services;

use App\Http\Modules\PatologiaRespiratoria\Models\PatologiaRespiratoria;
use App\Http\Modules\PatologiaRespiratoria\Repositories\PatologiaRespiratoriaRepository;
use Illuminate\Support\Facades\Auth;

class PatologiaRespiratoriaService
{
    public function __construct(private PatologiaRespiratoriaRepository $patologiaRespiratoriaRepository,) {}

    public function CrearPatologiaRespiratoria($request)
    {
        $patologiaRespiratoria = PatologiaRespiratoria::updateOrCreate([
            'consulta_id' => $request['consulta_id'],
            'creado_por' => Auth::id(),
        ],$request);



        return $patologiaRespiratoria;
    }
}
