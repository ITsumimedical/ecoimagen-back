<?php

namespace App\Http\Modules\Clasificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class clasificacion extends Model
{
    use SoftDeletes;

    protected $guarded = [];    

    /** Relaciones */

    /** Scopes */

    public function scopeWhereEstado($query, $estado){
        if($estado == "1"){
            return  $query->where('estado', 1);
        }
    }
    /** Sets y Gets */

}
