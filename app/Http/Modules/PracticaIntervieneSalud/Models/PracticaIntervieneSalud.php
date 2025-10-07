<?php

namespace App\Http\Modules\PracticaIntervieneSalud\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticaIntervieneSalud extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_practica', 'practica_id', 'caracterizacion_id');
    }
}
