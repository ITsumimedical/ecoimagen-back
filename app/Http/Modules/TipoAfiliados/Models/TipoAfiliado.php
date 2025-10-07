<?php

namespace App\Http\Modules\TipoAfiliados\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAfiliado extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'clasificacion_afiliado',
        'estado',
        'user_id',
    ];

}
