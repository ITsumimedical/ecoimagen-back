<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCancerPulmon extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id', 
        'laboratorio_procesa',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'tipo_cancer_pulmon',
        'subtipo_histologico',
        'nota_subtipo_histologico',
        'clasificacion_t',
        'clasificacion_n',
        'clasificacion_m',
        'estadio_inicial',
        'panel_molecular',
        'egfr',
        'alk',
        'ros_1',
        'pd_l1',
    ];
}
