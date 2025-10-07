<?php

namespace App\Http\Modules\GestionConocimientos\Capacitaciones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionConocimientos\Capacitaciones\Models\SolicitudCapacitacion;

class SolicitudCapacitacionRepository extends RepositoryBase {

    protected $solicitudCapacitacionModel;

    public function __construct(){
        $this->solicitudCapacitacionModel = new SolicitudCapacitacion();
        parent::__construct($this->solicitudCapacitacionModel);
    }
}
