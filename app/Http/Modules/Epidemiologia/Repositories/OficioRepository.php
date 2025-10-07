<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epidemiologia\Models\Oficio;

class OficioRepository extends RepositoryBase {
    public function __construct(protected Oficio $oficioModel)
    {
        parent::__construct($this->oficioModel);
    }

    /**
     * Consulta los oficios por nombre, usando el método whereNombreOficio del modelo
     * @param $data
     * @author Sofia O
     */
    public function listarOficiosNombre($data)
    {
        return $this->oficioModel->whereNombreOficio($data->nombre_oficio)->get();
    }
}
