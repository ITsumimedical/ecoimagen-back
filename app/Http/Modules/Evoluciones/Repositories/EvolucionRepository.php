<?php

namespace App\Http\Modules\Evoluciones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Evoluciones\Models\Evolucion;
use Illuminate\Support\Collection;


class EvolucionRepository extends RepositoryBase
{

    public function __construct(protected Evolucion $evolucion)
    {
        parent::__construct($this->evolucion);
    }

    /**
     * Lista las evoluciones de una admision de urgencias
     * @param int $admisionUrgenciasId
     * @return Collection
     * @author Thomas
     */
    public function listarEvolucionesAdmision(int $admisionUrgenciasId): Collection
    {
        return $this->evolucion
            ->with(['createBy.operador'])
            ->where('admision_urgencia_id', $admisionUrgenciasId)
            ->orderBy('id')
            ->get();
    }
}
