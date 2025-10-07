<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostoEvitado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['costo', 'descripcion', 'valor', 'tipo_alta', 'ingreso_concurrencia_id', 'user_id', 'user_elimina_id', 'motivo_anulacion'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userElimina()
    {
        return $this->belongsTo(User::class, 'user_elimina_id');
    }
}
