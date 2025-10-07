<?php

namespace App\Http\Modules\CuestionarioVale\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuestionarioVale extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'bajo_peso',
        'nacio_antes',
        'estancia_superior',
        'complicaciones_bebe',
        'descripcion_complicaciones',
        'bebe_diagnosticado',
        'descripcion_diagnosticos',
        'condicion_riesgo_social',
        'descripcion_riesgo_social',
        'dificultad_aprendizaje',
        'descripcion_dificultades',
        'orejas',
        'labios',
        'lengua',
        'nariz',
        'paladar',
        'ojos',
        'dientes',
        'cuello',
        'hombros',
        'interpretacion_resultado',  
        'integridad_orejas',
        'integridad_labios',
        'integridad_lengua',
        'integridad_nariz',
        'integridad_paladar',
        'integridad_ojos',
        'integridad_dientes',
        'integridad_cuello',
        'integridad_hombros',
        'remision_urgente',
        'valorItemC',
        'valorItemE',
        'valorItemI',
        'valorItemV',
        'observacionesItems',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
