<?php

namespace App\Http\Modules\testSrq\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class srq extends Model
{
    use HasFactory;

    protected $fillable = [
        'dolor_cabeza_frecuente',
        'mal_apetito',
        'duerme_mal',
        'asusta_facilidad',
        'temblor_manos',
        'nervioso_tenso',
        'mala_digestion',
        'pensar_claridad',
        'siente_triste',
        'llora_frecuencia',
        'dificultad_disfrutar',
        'tomar_decisiones',
        'dificultad_hacer_trabajo',
        'incapaz_util',
        'interes_cosas',
        'inutil',
        'idea_acabar_vida',
        'cansado_tiempo',
        'estomago_desagradable',
        'cansa_facilidad',
        'herirlo_forma',
        'importante_demas',
        'voces',
        'convulsiones_ataques',
        'demasiado_licor',
        'dejar_beber',
        'beber_trabajo',
        'detenido_borracho',
        'bebia_demasiado',
        'consulta_id',
        'interpretacion_resultado'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
