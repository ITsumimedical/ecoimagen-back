<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistroEscalaAbreviadaDesarrollo extends Model
{
    use HasFactory;

    protected $table = 'registro_escala_abreviada_desarrollos';
    protected $fillable = [
        'id',
        'consulta_id',
        'punto_inicio_motricidad_gruesa',
        'puntuacion_directa_motricidad_gruesa',
        'punto_inicio_motricidad_finoadaptativa',
        'puntuacion_directa_motricidad_finoadaptativa',
        'punto_inicio_audicion_lenguaje',
        'puntuacion_directa_audicion_lenguaje',
        'punto_inicio_persona_social',
        'puntuacion_directa_persona_social',
        'puntuacion_total_motricidad_gruesa',
        'puntuacion_total_motricidad_finoadaptativa',
        'puntuacion_total_audicion_lenguaje',
        'puntuacion_total_persona_social',
        'interpretacion_motricidad_gruesa',
        'interpretacion_finoadaptativa',
        'interpretacion_audicion_lenguaje',
        'interpretacion_persona_social',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
