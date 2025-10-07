<?php

namespace App\Http\Modules\ParametrizacionRemisionProgramas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ParametrizacionRemisionProgramas\Model\ParametrizacionRemisionProgramas;

class ParametrizacionRemisionProgramasRepository extends RepositoryBase
{

    protected $model;

    public function __construct(ParametrizacionRemisionProgramas $model)
    {
        $this->model = $model;
    }

    /**
     * listarPorEdadYSexo
     *
     * @param  mixed $edad
     * @param  mixed $sexo
     * @return void
     * @author Serna
     */
    public function listarPorEdadYSexo($edad,$sexo)
    {
        $programas = $this->model
            ->select(
                'id',
                'nombre',
                'edad_inicial',
                'edad_final',
                'sexo',
                'estado'
            )
            ->where('estado', true) // Solo programas activos
            ->whereIn('sexo', ['A', $sexo]) // Filtra por sexo
            ->where(function ($query) use ($edad) {
                $query->where('edad_inicial', '<=', $edad)
                    ->where('edad_final', '>=', $edad);
            })
            ->get();

        return $programas;
    }
}
