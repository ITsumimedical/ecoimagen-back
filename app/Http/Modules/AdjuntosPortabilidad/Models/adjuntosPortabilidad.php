<?php

namespace App\Http\Modules\AdjuntosPortabilidad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjuntosPortabilidad extends Model
{
    use SoftDeletes;

    protected $fillable =
    [
        'nombre',
        'ruta',
        'portabilidad_salida_id',
        'portabilidad_entrada_id'
    ];

    /** Relaciones */

    /** Scopes */

    /** Sets y Gets */

}
