<?php

namespace App\Http\Modules\Historia\AntecedentesPersonales\Services;

use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;

class AntecedentesService {

    public function guardarAntecedentes($request) {
            $antecedente = new AntecedentePersonale();
            $antecedente->patologias = $request['patologias'];
            $antecedente->otras = $request['otras'];
            $antecedente->tipo = $request['tipo'];
            $antecedente->fecha_diagnostico = $request['fecha_diagnostico'];
            $antecedente->cual = $request['cual'];
            $antecedente->descripcion = $request['descripcion'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $request['consulta_id'];
            $antecedente->save();
    }
}
