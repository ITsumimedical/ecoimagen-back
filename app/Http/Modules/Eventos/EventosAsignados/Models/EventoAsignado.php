<?php

namespace App\Http\Modules\Eventos\EventosAsignados\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoAsignado extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_adverso_id', 'user_id', 'accion_mejora_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
