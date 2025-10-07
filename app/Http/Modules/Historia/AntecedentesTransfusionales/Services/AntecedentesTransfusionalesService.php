<?php

namespace App\Http\Modules\Historia\AntecedentesTransfusionales\Services;

use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;

class AntecedentesTransfusionalesService
{

    public function guardarAntecedentes($datos)
    {
        $antecedente = new AntecedenteTransfusionale();
        $antecedente->tipo_transfusion = $datos['tipo_transfusion'];
        $antecedente->fecha_transfusion = $datos['fecha_transfusion'];
        $antecedente->causa = $datos['causa'];
        $antecedente->medico_registra = auth()->id();
        $antecedente->consulta_id = $datos['consulta_id'];
        $antecedente->save();
    }

    public function eliminar($id)
    {
        $antecedente = AntecedenteTransfusionale::findOrFail($id);
        $antecedente->delete();
    }
}
