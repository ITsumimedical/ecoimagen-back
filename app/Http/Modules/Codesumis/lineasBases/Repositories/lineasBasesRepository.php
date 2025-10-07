<?php

namespace App\Http\Modules\Codesumis\lineasBases\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Codesumis\lineasBases\Model\lineasBases;

class lineasBasesRepository extends RepositoryBase {

    protected $lineaBase;

    public function __construct()
    {
        $this->lineaBase = new lineasBases();
        parent::__construct($this->lineaBase);
    }

    public function listarLineas() {
        return $this->lineaBase->select(
            'lineas_bases.id',
            'lineas_bases.nombre'
        )
        ->get();
    }

    public function actualizarLinea($id, array $data)
    {
        $linea = $this->lineaBase->find($id);

        if (!$linea) {
            throw new \Exception("Linea Base no existe");
        }

        $linea->update($data);
        return $linea;
    }
}
