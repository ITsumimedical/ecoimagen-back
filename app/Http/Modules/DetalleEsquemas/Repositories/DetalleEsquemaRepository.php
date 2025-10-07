<?php

namespace App\Http\Modules\DetalleEsquemas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DetalleEsquemas\Models\DetalleEsquema;

class DetalleEsquemaRepository extends RepositoryBase
{

    public function __construct(protected DetalleEsquema $DetalleEsquemaModel)
    {
        parent::__construct($this->DetalleEsquemaModel);
    }


}
