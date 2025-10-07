<?php

namespace App\Http\Modules\MesaAyuda\SeguimientoActividades\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoActividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'respuesta',
        'mesa_ayuda_id',
        'adjunto_mesa_ayuda_id',
        'estado_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
