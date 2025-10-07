<?php

namespace App\Http\Modules\ConductasRelacionamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConductasRelacionamiento\Model\ConductaRelacionamiento;

class ConductaRelacionamientoRepository extends RepositoryBase {

    public function __construct(protected ConductaRelacionamiento $conductaRelacionamiento)
    {
        parent::__construct($this->conductaRelacionamiento);
    }

    public function crearConducta(array $data)
    {
        return $this->conductaRelacionamiento->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }
}
