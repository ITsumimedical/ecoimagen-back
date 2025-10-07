<?php

namespace App\Http\Modules\TipoRespiratoriasCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRespiratoriasCaracterizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_respiratorias', 'tipo_respiratoria_id', 'caracterizacion_id');
    }
}
