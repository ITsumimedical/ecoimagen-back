<?php

namespace App\Http\Modules\Historia\estratificacionFindrisks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstratificacionFindrisks extends Model
{
    use HasFactory;

    protected $fillable = [
        'edad_puntaje',
        'indice_corporal',
        'perimetro_abdominal',
        'actividad_fisica',
        'puntaje_fisica',
        'frutas_verduras',
        'hipertension',
        'resultado_hipertension',
        'glucosa',
        'resultado_glucosa',
        'diabetes',
        'parentezco',
        'resultado_diabetes',
        'totales',
        'usuario_id',
        'afiliado_id',
        'consulta_id',
        'estado_id',
        'resultado',
    ];
}
