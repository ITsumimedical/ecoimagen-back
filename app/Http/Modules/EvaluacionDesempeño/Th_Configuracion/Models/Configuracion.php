<?php

namespace App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_inicio_evaluacion_desempeno',
        'fecha_final_evaluacion_desempeno',
        'generado_por'
    ];
}
