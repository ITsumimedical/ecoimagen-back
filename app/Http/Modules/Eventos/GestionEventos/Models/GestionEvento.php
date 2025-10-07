<?php

namespace App\Http\Modules\Eventos\GestionEventos\Models;

use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionEvento extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_adverso_id', 'user_id', 'accion', 'motivo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evento()
    {
        return $this->belongsTo(EventoAdverso::class, 'evento_adverso_id');
    }
}
