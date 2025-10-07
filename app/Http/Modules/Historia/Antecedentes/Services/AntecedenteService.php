<?php

namespace App\Http\Modules\Historia\Antecedentes\Services;

use App\Http\Modules\Historia\Antecedentes\Models\Antecedente;
use Illuminate\Support\Facades\Log;

class AntecedenteService {

    public function guardarAntecedentes($request) {
        foreach ($request as $datos) {
            $antecedente = new Antecedente();
            $antecedente->antecedentes = $datos['antecedente'];
            $antecedente->descripcion = $datos['descripcion'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $datos['consulta_id'];
            $antecedente->save();
        }
    }
}
