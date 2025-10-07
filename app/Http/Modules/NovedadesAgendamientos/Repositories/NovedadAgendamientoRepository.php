<?php

namespace App\Http\Modules\NovedadesAgendamientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAgendamientos\Models\NovedadAgendamiento;

class NovedadAgendamientoRepository extends RepositoryBase {

    protected $novedadAgendamientoModel;

    public function __construct()
    {
        $novedadAgendamientoModel = new NovedadAgendamiento();
        parent::__construct($novedadAgendamientoModel);
        $this->model = $novedadAgendamientoModel;
    }

}
