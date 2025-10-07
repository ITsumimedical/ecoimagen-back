<?php

namespace App\Http\Modules\PlantillaHistoria\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaHistoria extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function categorias(){

        return $this->hasMany(PlantillaCategoria::class);
    }

}
