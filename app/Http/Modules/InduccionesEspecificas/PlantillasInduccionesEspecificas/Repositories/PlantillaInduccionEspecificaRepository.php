<?php

namespace App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Models\PlantillaInduccionEspecifica;

class PlantillaInduccionEspecificaRepository extends RepositoryBase {


    protected $plantillaModel;

    public function __construct() {
        $this->plantillaModel = new PlantillaInduccionEspecifica();
        parent::__construct($this->plantillaModel);
    }
}
