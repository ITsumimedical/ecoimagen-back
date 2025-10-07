<?php

namespace App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Models;

use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models\TemaInduccionEspecifica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaInduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function temas()
    {
        return $this->hasMany(TemaInduccionEspecifica::class);
    }
}
