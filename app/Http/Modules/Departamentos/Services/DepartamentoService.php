<?php

namespace App\Http\Modules\Departamentos\Services;

use App\Http\Modules\Departamentos\Models\Departamento;

class DepartamentoService
{
    /**
     * Método para listar todos los departamentos con sus municipios asociados.
     * 
     * @return Colección de departamentos con sus municipios.
     * @author kobatime
     * @since 13 agosto 2024
     */
    public function listarDepartamentos()
    {
        // Utiliza el modelo Departamento para obtener todos los departamentos junto con sus municipios relacionados.
        // El método with() realiza una (eager loading) de la relación municipios.
        $departamento = Departamento::with('municipios:id,nombre,departamento_id,codigo_dane');

        // Obtiene los departamentos de la base de datos y los devuelve.
        return $departamento->get();
    }

}