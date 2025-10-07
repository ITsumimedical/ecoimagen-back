<?php

namespace App\Http\Modules\TipoMetabolicasCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMetabolicasCaracterizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];


    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_metabolicas', 'tipo_metabolica_id', 'caracterizacion_id');
    }
}
