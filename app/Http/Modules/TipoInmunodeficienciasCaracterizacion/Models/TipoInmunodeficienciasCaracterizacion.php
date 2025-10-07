<?php

namespace App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInmunodeficienciasCaracterizacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_inmunodeficiencias_caracterizacions';
    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_inmunodeficiencias', 'tipo_inmunodeficiencia_id', 'caracterizacion_id');
    }
}
