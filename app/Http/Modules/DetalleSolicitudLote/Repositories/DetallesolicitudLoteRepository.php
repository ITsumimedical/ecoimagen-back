<?php

namespace App\Http\Modules\DetalleSolicitudLote\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DetalleSolicitudLote\Models\DetalleSolicitudLote;

class DetallesolicitudLoteRepository extends RepositoryBase
{

    public function __construct(DetalleSolicitudLote $model)
    {
        $this->model = $model;
    }
}
