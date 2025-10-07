<?php

namespace App\Http\Modules\Historia\ResultadoLaboratorio\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultadoLaboratorio extends Model
{
    use HasFactory;

    protected $fillable = ['laboratorio','resultado_lab','factor_rh','fecha_laboratorio','adjunto','medico_registra','consulta_id','meta_individual'];

    public function consulta()
        {
        return $this->belongsTo(Consulta::class);
        }

    protected $casts = [ 'created_at' => 'datetime:Y-m-d'];

     public function user()
        {
            return $this->belongsTo(User::class,'medico_registra');
        }
}
