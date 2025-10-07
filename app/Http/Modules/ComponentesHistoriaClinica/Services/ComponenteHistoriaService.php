<?php

namespace App\Http\Modules\ComponentesHistoriaClinica\Services;

use App\Http\Modules\ComponentesHistoriaClinica\Model\ComponentesHistoriaClinica;

class ComponenteHistoriaService {


    /**
     * actualizar
     * Actualizar un componente recibiendo el id y la data
     * @param  mixed $id
     * @param  mixed $data
     * @return void
     */
    public function actualizar(int $id, array $data)
    {
        return ComponentesHistoriaClinica::findOrFail($id)->update($data);
    }
}
