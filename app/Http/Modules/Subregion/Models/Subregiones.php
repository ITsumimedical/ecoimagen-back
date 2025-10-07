<?php

namespace App\Http\Modules\Subregion\Models;

use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subregiones extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /** Relaciones */
    public function municipio(){
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    /** Scopes */

    /** Sets y Gets */

}
