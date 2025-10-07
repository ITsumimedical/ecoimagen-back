<?php

namespace App\Http\Modules\Historia\Models;

use App\Http\Modules\ConsultaCausaExterna\Model\ConsultaCausaExterna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\FinalidadConsulta\Model\FinalidadConsulta;
use App\Http\Modules\NotaAclaratoria\Models\NotaAclaratoria;

class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';

    protected $guarded = [];

    protected $casts = [
        'sin_dolor' => 'integer',
        'sin_cansancio' => 'integer',
        'sin_nauseas' => 'integer',
        'sin_tristeza' => 'integer',
        'sin_ansiedad' => 'integer',
        'sin_somnolencia' => 'integer',
        'sin_disnea' => 'integer',
        'buen_apetito' => 'integer',
        'maximo_bienestar' => 'integer',
        'sin_dificulta_para_dormir' => 'integer',
        'barthel_comer' => 'integer',
        'barthel_lavarse' => 'integer',
        'barthel_vestirse' => 'integer',
        'barthel_arreglarse' => 'integer',
        'barthel_deposiciones' => 'integer',
        'barthel_miccion' => 'integer',
        'barthel_retrete' => 'integer',
        'barthel_trasladarse' => 'integer',
        'barthel_deambular' => 'integer',
        'barthel_escalones' => 'integer',
        'interpretacion_barthel' => 'string',
        'ayuda_familia' => 'integer',
        'familia_habla_con_usted' => 'integer',
        'cosas_nuevas' => 'integer',
        'le_gusta_familia_hace' => 'integer',
        'le_gusta_familia_comparte' => 'integer',
        'resultado' => 'integer',
    ];

    public function consulta()
    {
      return $this->belongsTo(Consulta::class);
      }

    public function notaAclaratoria()
    {
        return $this->belongsToMany(NotaAclaratoria::class)->withTimestamps();
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_id_resultado_ayudas_diagnosticas');
    }

    public function cupMenor()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }

    public function finalidadConsulta()
    {
        return $this->belongsTo(FinalidadConsulta::class, 'finalidad_id');
    }

    public function causaConsulta()
    {
        return $this->belongsTo(ConsultaCausaExterna::class, 'causa_consulta_externa_id');
    }
}
