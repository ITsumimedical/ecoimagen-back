<?php

namespace App\Http\Modules\Historia\estratificacionFramingham\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstratificacionFraminghams extends Model
{
    protected $fillable = [
        'tratamiento',
        'edad_puntaje',
        'colesterol_total',
        'colesterol_puntaje',
        'colesterol_hdl',
        'colesterol_puntajehdl',
        'fumador_puntaje',
        'arterial_puntaje',
        'totales',
        'usuario_id',
        'afiliado_id',
        'consulta_id',
        'estado_id',
        'diabetes_puntaje',
        'porcentaje',
        'resultado'
    ];

    use HasFactory;
}
