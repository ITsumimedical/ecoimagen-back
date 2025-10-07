<?php

namespace App\Http\Modules\Historia\AntecedentesQuirurgicos\Services;

use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;

class AntecedenteQuirurgicoService
{

    public function guardarAntecedentes($datos)
    {

        $antecedente = new AntecedenteQuirurgico();
        $antecedente->cirugia = $datos['cirugia'];
        $antecedente->a_que_edad = $datos['a_que_edad'];
        $antecedente->medico_registra = auth()->id();
        $antecedente->consulta_id = $datos['consulta_id'];
        $antecedente->observaciones = $datos['observaciones'];
        $antecedente->save();
    }

    public function eliminar($id)
    {

        $antecedente = AntecedenteQuirurgico::findOrFail($id);
        $antecedente->delete();
    }
}
