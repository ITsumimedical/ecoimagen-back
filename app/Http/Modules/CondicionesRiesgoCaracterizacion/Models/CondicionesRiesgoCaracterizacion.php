<?php

namespace App\Http\Modules\CondicionesRiesgoCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionesRiesgoCaracterizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_riesgos', 'condicion_riesgo_id', 'caracterizacion_id');
    }
}
