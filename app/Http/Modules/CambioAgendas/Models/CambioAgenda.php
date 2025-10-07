<?php

namespace App\Http\Modules\CambioAgendas\Models;

use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioAgenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'user_id',
        'motivo',
        'accion',
        'consultorio_origen_id',
        'consultorio_destino_id'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultorioOrigen()
    {
        return $this->belongsTo(Consultorio::class, 'consultorio_origen_id');
    }

    public function consultorioDestino()
    {
        return $this->belongsTo(Consultorio::class, 'consultorio_destino_id');
    }
}
