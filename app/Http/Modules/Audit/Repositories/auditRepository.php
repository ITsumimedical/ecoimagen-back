<?php

namespace App\Http\Modules\Audit\Repositories;

use App\Http\Modules\Audit\Model\audit;
use App\Http\Modules\Bases\RepositoryBase;

class auditRepository extends RepositoryBase {


    public function __construct(protected audit $audit)
    {
        parent::__construct($this->audit);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->audit
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
