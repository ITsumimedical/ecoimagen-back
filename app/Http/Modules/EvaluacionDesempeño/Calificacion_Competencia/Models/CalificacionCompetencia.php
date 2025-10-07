<?php

namespace App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Models;

use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalificacionCompetencia extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts=[
        'calificacion' => 'integer',
        'evaluaciones_desempeno_id' => 'integer',
       ];



}
