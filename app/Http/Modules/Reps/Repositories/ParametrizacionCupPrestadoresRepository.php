<?php

namespace App\Http\Modules\Reps\Repositories;

use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Sedes\Models\Sede;

class ParametrizacionCupPrestadoresRepository extends RepositoryBase
{

    protected $model;

    public function __construct()
    {
        $this->model = new ParametrizacionCupPrestador();
        parent::__construct($this->model);
    }

    public function listarParametrizacion()
    {
       return $this->model->with('cup','sede','CodigoPropio')->get();
    }

    public function eliminar($id)
    {
        return $this->model->destroy($id);
    }
}
