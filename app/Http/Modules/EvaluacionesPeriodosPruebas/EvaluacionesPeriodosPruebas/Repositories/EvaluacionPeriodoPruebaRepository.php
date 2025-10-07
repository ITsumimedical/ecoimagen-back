<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Models\EvaluacionPeriodoPrueba;

class EvaluacionPeriodoPruebaRepository extends RepositoryBase {

    protected $evaluacionModel;

    public function __construct() {
        $this->evaluacionModel = new EvaluacionPeriodoPrueba();
        parent::__construct($this->evaluacionModel);
    }

    public function listarEvaluaciones(){
        $evaluaciones = EvaluacionPeriodoPrueba::select('evaluacion_periodo_pruebas.id', 'evaluacion_periodo_pruebas.fecha_evaluacion',
        'evaluacion_periodo_pruebas.empleado_evaluado_id', 'evaluacion_periodo_pruebas.usuario_registra_id',
        'evaluacion_periodo_pruebas.descripcion_experiencia_empresa', 'evaluacion_periodo_pruebas.descripcion_experiencia_induccion',
        'evaluacion_periodo_pruebas.aprueba_periodo_prueba', 'evaluacion_periodo_pruebas.observaciones',
        'evaluacion_periodo_pruebas.created_at', 'empleados.nombre_completo as evaluado_nombre', 'empleados.documento as evaluado_documento',
        'empleados.sede_id as evaluado_sede', 'sedes.nombre as evaluado_sede', 'cargos.nombre as evaluado_cargo', 'usuarioRegistra.nombre_completo as evaluador_nonbre',
        )
        ->join('empleados', 'empleados.id', 'evaluacion_periodo_pruebas.empleado_evaluado_id')
        ->join('sedes', 'sedes.id', 'empleados.sede_id')
        ->leftjoin('contrato_empleados', 'empleados.id', 'contrato_empleados.empleado_id')
        ->leftjoin('cargos', 'contrato_empleados.cargo_id', 'cargos.id')
        ->join('users', 'users.id', 'evaluacion_periodo_pruebas.usuario_registra_id')
        ->join('empleados as usuarioRegistra', 'users.id', 'usuarioRegistra.user_id')
        ->get();
        return $evaluaciones;
    }
}
