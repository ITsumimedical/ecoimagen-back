<?php

namespace App\Http\Modules\Historia\Vacunacion\Services;

use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;

class VacunacionService {

    public function guardarAntecedentes($datos) {
        $otra =null;
            if(isset($datos['otra'])){
                $otra = $datos['otra'];
            }
            $antecedente = new Vacuna();
            $antecedente->vacuna = $datos['vacuna'];
            $antecedente->dosis = $datos['dosis'];
            $antecedente->laboratorio = $datos['laboratorio'];
            $antecedente->fecha_dosis = $datos['fecha_dosis'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $datos['consulta_id'];
            $antecedente->otra = $otra;
            $antecedente->save();
    }
}
