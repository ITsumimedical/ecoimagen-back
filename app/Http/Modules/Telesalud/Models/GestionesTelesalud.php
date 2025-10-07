<?php

namespace App\Http\Modules\Telesalud\Models;

use App\Http\Modules\ConsultaCausaExterna\Model\ConsultaCausaExterna;
use App\Http\Modules\FinalidadConsulta\Model\FinalidadConsulta;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionesTelesalud extends Model
{
    use HasFactory;

    protected $fillable = [
        'telesalud_id',
        'tipo_id',
        'funcionario_gestiona_id',
        'prioridad',
        'pertinencia_solicitud',
        'observacion',
        'institucion_prestadora_id',
        'eapb_id',
        'evaluacion_junta',
        'junta_aprueba',
        'clasificacion_prioridad',
        'finalidad_consulta_id',
        'causa_externa_id',
    ];

    public function adjuntos()
    {
        return $this->hasMany(AdjuntosTelesalud::class, 'gestion_telesalud_id');
    }

    public function funcionarioGestiona()
    {
        return $this->belongsTo(User::class, 'funcionario_gestiona_id');
    }

    public function institucionPrestadora()
    {
        return $this->belongsTo(Rep::class, 'institucion_prestadora_id');
    }

    public function eapb()
    {
        return $this->belongsTo(Rep::class, 'eapb_id');
    }

    public function finalidad()
    {
        return $this->belongsTo(FinalidadConsulta::class, 'finalidad_consulta_id');
    }

    public function causas()
    {
        return $this->belongsTo(ConsultaCausaExterna::class, 'causa_externa_id');
    }
}
