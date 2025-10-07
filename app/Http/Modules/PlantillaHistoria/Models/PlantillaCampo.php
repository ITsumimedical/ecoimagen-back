<?php

namespace App\Http\Modules\PlantillaHistoria\Models;

use App\Http\Modules\TipoCampo\Models\TipoCampo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaCampo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function tipoCampoHistoria(){
        return $this->belongsTo(TipoCampo::class,'tipo_campo_id');
    }
}
