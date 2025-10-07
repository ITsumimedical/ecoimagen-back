<?php

namespace App\Http\Modules\AsignacionCamas\Models;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionCama extends Model
{
    use HasFactory;

    protected $fillable = ['fecha','tipo_cama','cama_id','admision_urgencia_id','estado_id','created_by','updated_by'];

    public function admisionUrgencia()
    {
        return $this->belongsTo(AdmisionesUrgencia::class);
    }
}
