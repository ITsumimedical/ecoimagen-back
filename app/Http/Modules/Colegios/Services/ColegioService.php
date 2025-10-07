<?php

namespace App\Http\Modules\Colegios\Services;

use App\Http\Modules\Colegios\Models\Colegio;

class ColegioService
{

    public function listarColegiosDepartamento($departamento_id) {
        $colegios = Colegio::whereHas('municipio', function($query) use ($departamento_id) {
            $query->where('departamento_id', $departamento_id);
        })->with('municipio')->get();

        return $colegios;
    }
}