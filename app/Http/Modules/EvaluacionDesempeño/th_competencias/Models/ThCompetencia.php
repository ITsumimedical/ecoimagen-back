<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_competencias\Models;

use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThCompetencia extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function pilar()
    {
        return $this->belongsTo(ThPilar::class);
    }

}
