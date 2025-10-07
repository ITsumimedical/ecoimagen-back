<?php

namespace App\Http\Modules\MesaAyuda\SeguimientoActividades\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Models\SeguimientoActividades;

class SeguimientoActividadesRepository extends RepositoryBase
{
    protected $seguimientoActividadesModel;

    public function __construct(SeguimientoActividades $seguimientoActividadesModel){
        parent::__construct($seguimientoActividadesModel);
        $this->seguimientoActividadesModel = $seguimientoActividadesModel;
    }
}
