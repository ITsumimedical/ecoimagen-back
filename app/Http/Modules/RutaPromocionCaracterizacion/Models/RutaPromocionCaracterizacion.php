<?php

namespace App\Http\Modules\RutaPromocionCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaPromocionCaracterizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_rutas', 'ruta_promocion_id', 'caracterizacion_id');
    }
}
