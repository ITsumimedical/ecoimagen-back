<?php

namespace App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignadosMesaAyuda extends Model
{
    use HasFactory;

    protected $fillable =['mesa_ayuda_id','categoria_mesa_ayuda_id','user_id','estado_id'];
}
