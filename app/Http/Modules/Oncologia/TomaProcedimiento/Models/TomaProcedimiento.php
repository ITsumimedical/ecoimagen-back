<?php

namespace App\Http\Modules\Oncologia\TomaProcedimiento\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Oncologia\AdjuntosOncologicos\Models\AdjuntosOncologico;
use App\Http\Modules\Oncologia\Organos\Models\Organo;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TomaProcedimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_radicacion',
        'fecha_procedimiento',
        'fecha_ingreso_muestra',
        'fecha_salida_muestra',
        'grado_infiltracion',
        'grado_histologico',
        'clasificacion_muestra',
        'biopsia',
        'rep_id',
        'afiliado_id',
        'organo_id',
        'cie10_id',
        'consulta_id',
        'registrado_por_id',
        'estado_id',
        'sistema',
        'observaciones',
        'seguimiento'
    ];

    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }
    public function organo(){
        return $this->belongsTo(Organo::class);
    }
    public function afiliado(){
        return $this->belongsTo(Afiliado::class);
    }
    public function rep(){
        return $this->belongsTo(Rep::class);
    }
    public function registrado()
    {
        return $this->belongsTo(Operadore::class,'registrado_por_id','user_id');
    }

    public function adjunto(){
        return $this->hasOne(AdjuntosOncologico::class);
    }
}

