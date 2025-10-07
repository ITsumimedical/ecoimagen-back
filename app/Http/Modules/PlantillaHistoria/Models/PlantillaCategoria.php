<?php

namespace App\Http\Modules\PlantillaHistoria\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaCategoria extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function campos(){

        return $this->hasMany(PlantillaCampo::class);
    }
}
