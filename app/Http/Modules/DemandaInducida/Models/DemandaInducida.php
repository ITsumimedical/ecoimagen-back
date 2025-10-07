<?php

namespace App\Http\Modules\DemandaInducida\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandaInducida extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_demanda_inducida',
        'programa_remitido',
        'fecha_dx_riesgo_cardiovascular',
        'descripcion_evento_salud_publica',
        'descripcion_otro_programa',
        'observaciones',
        'demanda_inducida_efectiva',
        'afiliado_id',
        'usuario_registra_id',
        'consulta_1_id',
        'consulta_2_id',
        'consulta_3_id',
        'fecha_registro'
    ];

    public function reps()
    {
        return $this->belongsTo(Rep::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function agendas()
    {
        return $this->belongsTo(Agenda::class, 'consultorio_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);

    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'nombre');
    }
}
