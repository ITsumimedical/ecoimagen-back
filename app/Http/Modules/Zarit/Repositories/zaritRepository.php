<?php

namespace App\Http\Modules\Zarit\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Zarit\Model\zarit;

class zaritRepository extends RepositoryBase {


    public function __construct(protected zarit $zarit)
    {
        parent::__construct($this->zarit);
    }


    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->zarit
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest('id')
            ->first();
    }
}
