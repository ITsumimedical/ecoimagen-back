<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models;

use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThTipoPlantilla extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function pilares()
    {
        return $this->hasMany(ThPilar::class);
    }

}
