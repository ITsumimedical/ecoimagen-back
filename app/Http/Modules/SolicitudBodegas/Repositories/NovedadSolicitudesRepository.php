<?php

namespace App\Http\Modules\SolicitudBodegas\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SolicitudBodegas\Models\NovedadSolicitudes;

class NovedadSolicitudesRepository extends RepositoryBase
{
    protected $SolicitudBodegaModel;

    public function __construct() {
        $this->SolicitudBodegaModel = new NovedadSolicitudes();
        parent::__construct($this->SolicitudBodegaModel);
    }

}
