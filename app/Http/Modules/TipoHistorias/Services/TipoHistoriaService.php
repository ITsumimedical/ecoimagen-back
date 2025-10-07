<?php

namespace App\Http\Modules\TipoHistorias\Services;

use App\Http\Modules\TipoHistorias\Models\TipoHistoria;

class TipoHistoriaService {

    public function actualizar(int $id, array $data) {
        return TipoHistoria::findOrFail($id)->update($data);
    }

    public function agregarComponentesTipoHistoria(array $data)
    {
        $tipoHistoria = TipoHistoria::findOrFail($data['tipo_historia_id']);
        $componentesData = [];
        foreach ($data['componentes'] as $componente) {
            $componentesData[$componente['id']] = ['orden_componente' => $componente['orden']];
        }
        return $tipoHistoria->componentesHistoriaClinica()->sync($componentesData);
    }

    public function obtenerComponentesTipoHistoria(int $tipo_historia_id)
    {
        return TipoHistoria::findOrFail($tipo_historia_id)->componentesHistoriaClinica()->get();
    }


}
