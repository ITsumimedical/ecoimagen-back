<?php

namespace App\Http\Modules\Eventos\AccionesMejora\Models;

use App\Http\Modules\Eventos\Adjunto\Models\AdjuntoEventoAdverso;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\EventosAsignados\Models\EventoAsignado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccionesMejoraEvento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nombre', 'responsable', 'fecha_cumplimiento', 'fecha_seguimiento', 'estado', 'analisis_evento_id', 'observacion'];

    public function analisisEvento()
    {
        return $this->belongsTo(AnalisisEvento::class);
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntoEventoAdverso::class, 'accion_mejora_id');
    }

    public function eventosAsignados()
    {
        return $this->hasMany(EventoAsignado::class, 'accion_mejora_id');
    }


    protected $casts = [
        'responsable' => 'array',
    ];
}
