<?php

namespace App\Http\Modules\GrupoServicios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GrupoServicios\Model\grupoServicios;

class grupoServiciosRepository extends RepositoryBase {

    public function __construct(protected grupoServicios $grupoServicios)
    {
        parent::__construct($this->grupoServicios);
    }

    public function update(int $id, array $data)
    {
        $grupo = $this->grupoServicios->findOrFail($id);
        $grupo->update($data);
    }
}
