<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_pilares\Models;

use App\Http\Modules\EvaluacionDesempeño\th_competencias\Models\ThCompetencia;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThPilar extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function plantilla(){
        return $this->belongsTo(ThTipoPlantilla::class);
    }

    public function competencias()
    {
        return $this->hasMany(ThCompetencia::class);
    }

}
