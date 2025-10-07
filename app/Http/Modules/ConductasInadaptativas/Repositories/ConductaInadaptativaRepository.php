<?php

namespace App\Http\Modules\ConductasInadaptativas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConductasInadaptativas\Model\ConductaInadaptativa;

class ConductaInadaptativaRepository extends RepositoryBase {

    public function __construct(protected ConductaInadaptativa $conductaInadaptativa)
    {
        parent::__construct($this->conductaInadaptativa);
    }

    public function crearConducta(array $data)
    {
        return $this->conductaInadaptativa->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }
}
