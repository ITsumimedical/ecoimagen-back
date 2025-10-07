<?php

namespace App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models;

use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Models\CalificacionCompetencia;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluacionesDesempeno extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'esta_activo' => 'integer'
    ];

    public function thTipoPlantilla()
    {
        return $this->belongsToMany(ThTipoPlantilla::class);
    }

}
