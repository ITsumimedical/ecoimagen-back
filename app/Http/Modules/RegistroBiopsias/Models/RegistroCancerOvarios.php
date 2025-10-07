<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCancerOvarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id',
        'lateralidad_1',
        'lateralidad_2',
        'laboratorio_procesa',
        'nombre_patologo',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'clasificacion_t',
        'clasificacion_n',
        'clasificacion_m',
        'estadio_figo',
        'descripcion_estadio_figo',
    ];
}
