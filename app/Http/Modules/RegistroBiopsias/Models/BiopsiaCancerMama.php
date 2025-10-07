<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiopsiaCancerMama extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_biopsias_patologia_id',
        'laboratorio_procesa',
        'nombre_patologo',
        'fecha_ingreso_ihq',
        'fecha_salida_ihq',
        'estrogenos',
        'progestagenos',
        'porcentaje_estrogenos',
        'porcentaje_progestagenos',
        'ki_67',
        'her2',
        'clasificacion_t',
        'descripcion_t',
        'clasificacion_n',
        'descripcion_n',
        'clasificacion_m',
        'descripcion_m',
        'subtipo_molecular',
        'fish',
        'brca',
        'estadio',
    ];
}
