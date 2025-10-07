<?php

namespace App\Http\Modules\TipoSolicitudBodegas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoSolicitudBodega extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /** Relaciones */

    /** Scopes */
    public function scopeWhereTipo($query,$tipo)
    {
        if($tipo){
            return $query->where($tipo,1);
        }
    }

        /** Sets y Gets */

}
