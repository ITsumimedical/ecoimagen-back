<?php

namespace App\Http\Modules\Eventos\Sucesos\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Eventos\UsuariosSuceso\Models\UsuariosSuceso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suceso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function usuarioSuceso(){
        return $this->hasMany(UsuariosSuceso::class, 'suceso_id');
    }
}
