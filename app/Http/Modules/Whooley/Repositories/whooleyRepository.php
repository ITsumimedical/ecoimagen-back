<?php

namespace App\Http\Modules\Whooley\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Whooley\Model\whooley;

class whooleyRepository extends RepositoryBase {


    public function __construct(protected whooley $whooley)
    {
        parent::__construct($this->whooley);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->whooley
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
