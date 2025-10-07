<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCancerGastrico extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id',
        'laboratorio_procesa',
        'ubicacion_leson',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'tipo_cancer_gastrico',
        'clasificacion_t',
        'clasificacion_n',
        'clasificacion_m',
        'estadio',
        'her_2',
        'pd_l1',
        'inestabilidad_microsatelital',
        'gen_ntrk',
        'nombre_patologo'
    ];
}
