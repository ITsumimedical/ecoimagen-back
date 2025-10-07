<?php

namespace App\Http\Modules\CategoriaHistorias\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCategoriaHistoria extends Model
{

    protected $guarded = [];

    public function TipoCategoria(){
        return $this->belongsTo(TipoCategoriaHistoria::class);
    }
}
