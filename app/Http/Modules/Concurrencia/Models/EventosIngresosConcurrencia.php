<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventosIngresosConcurrencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'evento',
        'observaciones',
        'tipo_evento',
        'ingreso_concurrencia_id',
        'user_id',
        'motivo_eliminacion',
        'user_elimina_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userElimina()
    {
        return $this->belongsTo(User::class, 'user_elimina_id');
    }
}
