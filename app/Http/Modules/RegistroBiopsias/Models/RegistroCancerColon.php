<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCancerColon extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id',
        'ubicacion_leson',
        'laboratorio_procesa',
        'nombre_patologo',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'tipo_cancer_colon',
        'subtipo_adenocarcinoma',
        'clasificacion_t',
        'clasificacion_n',
        'clasificacion_m',
        'estadio',
        'cambio_estadio',
    ];
}
