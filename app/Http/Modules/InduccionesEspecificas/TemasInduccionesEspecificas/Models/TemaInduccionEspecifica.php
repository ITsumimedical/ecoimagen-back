<?php

namespace App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models;

use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Models\PlantillaInduccionEspecifica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaInduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'plantilla_id' => 'integer',
    ];

    public function plantilla()
    {
        return $this->belongsTo(PlantillaInduccionEspecifica::class);
    }
}
