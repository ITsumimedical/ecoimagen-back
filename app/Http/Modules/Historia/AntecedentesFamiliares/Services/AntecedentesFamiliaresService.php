<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliares\Services;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;

class AntecedentesFamiliaresService {

    public function guardarAntecedentes($request) {
            $antecedente = new AntecedenteFamiliare();
            $antecedente->cie10_id = $request['cie10_id'];
            $antecedente->parentesco = $request['parentesco'];
            $antecedente->edad = $request['edad'];
            $antecedente->fallecido = $request['fallecido'];
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $request['consulta_id'];
            $antecedente->save();
    }
}
