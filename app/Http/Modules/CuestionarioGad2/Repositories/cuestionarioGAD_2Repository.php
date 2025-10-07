<?php

namespace App\Http\Modules\CuestionarioGad2\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuestionarioGad2\Model\cuestionarioGAD_2;

class cuestionarioGAD_2Repository extends RepositoryBase
{

    public function __construct(protected cuestionarioGAD_2 $cuestionario)
    {
        parent::__construct($this->cuestionario);
    }


    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->cuestionario
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
