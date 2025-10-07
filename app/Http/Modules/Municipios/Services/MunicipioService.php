<?php

namespace App\Http\Modules\Municipios\Services;

use App\Http\Modules\Municipios\Models\Municipio;

class MunicipioService {

    /**
     * Listar todos los municipios con sus departamentos asociados.
     *
     * @return Colección de municipios con sus departamentos.
     * @author kobatime
     * @since 13 agosto 2024
     */
    public function listar() {
        // Obtiene todos los municipios junto con sus departamentos relacionados.
        return Municipio::with('departamento')->get();
    }

    /**
     * Listar las sedes primarias (reps) de un municipio específico.
     *
     * @param int $municipio_id El ID del municipio.
     * @return Colección de reps que son sedes primarias.
     * @author kobatime
     * @since 13 de agosto 2024
     */
    public function listarSedesPrimarias($municipio_id){
        // Busca el municipio con las reps que tienen el campo 'ips_primaria' establecido en 1 (true).
        $municipio = Municipio::with(['reps' => function ($query) {
            $query->where('ips_primaria', 1);
        }])->findOrFail($municipio_id);

        // Devuelve las reps que son sedes primarias del municipio.
        return $municipio->reps;
    }

}