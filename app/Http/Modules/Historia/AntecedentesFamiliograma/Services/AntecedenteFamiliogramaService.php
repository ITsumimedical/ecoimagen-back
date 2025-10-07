<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliograma\Services;

use App\Http\Modules\Historia\AntecedentesFamiliograma\Models\AntecedenteFamiliograma;
use Illuminate\Support\Facades\Log;

class AntecedenteFamiliogramaService {

    public function guardarAntecedentes($request) {
            $antecedente = new AntecedenteFamiliograma();
            $antecedente->vinculos = $request['vinculos'];
            $antecedente->relacion = $request['relacion'];
            $antecedente->tipo_familia = $request['tipo_familia'];
            $antecedente->hijos_conforman = $request['hijos_conforman'];
            $antecedente->responsable_ingreso = $request['responsable_ingreso'];
            $antecedente->problemas_de_salud = $request['problemas_de_salud'] === 'Si' ? 'SI' : 'NO';
            $antecedente->responsable_ingreso = $request['responsable_ingreso'];
            $antecedente->observacion_salud = $request['observacion_salud'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $request['consulta_id'];
            $antecedente->save();
    }
}
