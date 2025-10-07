<?php

namespace App\Http\Modules\Historia\AntecedentesSexuales\Services;

use App\Http\Modules\Historia\AntecedentesSexuales\Models\AntecedenteSexuale;

class AntecedentesSexualesService {

    public function guardarAntecedentes($request) {
        foreach ($request as $datos) {
            $antecedente = new AntecedenteSexuale();
            $antecedente->tipo_antecedentes_sexuales = $datos['tipo_antecedentes_sexuales'];
            $antecedente->tipo_orientacion_sexual = $datos['tipo_orientacion_sexual'];
            $antecedente->tipo_identidad_genero = $datos['tipo_identidad_genero'];
            $antecedente->resultado = $datos['resultado'];
            $antecedente->cuantos = $datos['cuantos'];
            $antecedente->edad = $datos['edad'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $datos['consulta_id'];
            $antecedente->save();
        }
    }
}
