<?php

namespace App\Http\Modules\MiniMental\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MiniMental\Model\miniMental;

class miniMentalRepository extends RepositoryBase {


    public function __construct(protected miniMental $mental)
    {
        parent::__construct($this->mental);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->mental
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
