<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterioEvaluacionPeriodoPrueba extends Model
{

    protected $casts = [
        'plantilla_evaluacion_periodo_pruebas_id' => 'integer',
    ];

    protected $guarded = [];

    use HasFactory;
}
