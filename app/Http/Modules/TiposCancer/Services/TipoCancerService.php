<?php

namespace App\Http\Modules\TiposCancer\Services;

use App\Http\Modules\TiposCancer\Model\TipoCancer;

class TipoCancerService
{


    public function actualizar(int $id, array $data)
    {
        return TipoCancer::findOrFail($id)->update($data);
    }

    public function agregarCie10TipoCancer(array $data)
    {
        $cita = TipoCancer::where('id', $data['tipo_cancer_id'])->first();
        $cita->cie10s()->sync($data['cie_10_id']);
        return $cita;
    }
}
