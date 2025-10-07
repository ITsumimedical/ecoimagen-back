<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCancerProstata extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id',
        'psa',
        'lobulo',
        'lobulo_derecho',
        'lobulo_izquierdo',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'grado',
        'riesgo',
        'clasificacion_t',
        'descripcion_clasificacion_t',
        'clasificacion_m',
        'descripcion_clasificacion_m',
        'clasificacion_n',
        'descripcion_clasificacion_n', 
        'estadio',
        'extension',
    ];
}
