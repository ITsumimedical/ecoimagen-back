<?php

namespace App\Http\Modules\Ordenamiento\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoOrden extends Model
{
    use SoftDeletes;
    protected $table = "tipo_ordenes";

    protected $guarded = [];

    /** Relaciones */

    /** Scopes */

    /** Sets y Gets */

}
