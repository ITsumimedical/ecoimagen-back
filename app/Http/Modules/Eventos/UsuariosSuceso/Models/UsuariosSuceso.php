<?php

namespace App\Http\Modules\Eventos\UsuariosSuceso\Models;

use App\Http\Modules\Eventos\Sucesos\Models\Suceso;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuariosSuceso extends Model
{
    use HasFactory;

    protected $table = 'usuarios_sucesos';
    protected $fillable = ['suceso_id','user_id', 'usuario_defecto'];


    public function suceso()
    {
        return $this->belongsTo(Suceso::class, 'suceso_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
