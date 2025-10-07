<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Models\PlantillaEvaluacionPeriodoPrueba;

class PlantillaEvaluacionPeriodoPruebaRepository extends RepositoryBase {

    protected $plantillaModel;

    public function __construct() {
        $this->plantillaModel = new PlantillaEvaluacionPeriodoPrueba();
        parent::__construct($this->plantillaModel);
    }

}
