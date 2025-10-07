<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Models\CriterioEvaluacionPeriodoPrueba;

class CriterioEvaluacionPeriodoPruebaRepository extends RepositoryBase {

    protected $CriterioModel;

    public function __construct() {
        $this->CriterioModel = new CriterioEvaluacionPeriodoPrueba();
        parent::__construct($this->CriterioModel);
    }

    public function listarConPlantilla(){
        $criterios = CriterioEvaluacionPeriodoPrueba::select(
            'criterio_evaluacion_periodo_pruebas.id', 'criterio_evaluacion_periodo_pruebas.nombre', 'criterio_evaluacion_periodo_pruebas.plantilla_evaluacion_periodo_pruebas_id',
            'plantilla_evaluacion_periodo_pruebas.nombre as nombrePlantilla'
        )
        ->join('plantilla_evaluacion_periodo_pruebas', 'plantilla_evaluacion_periodo_pruebas.id', 'plantilla_evaluacion_periodo_pruebas_id')
        ->get();

        return $criterios;
    }
}
