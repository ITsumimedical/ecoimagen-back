<?php

namespace App\Http\Modules\IngresoDomiciliarios\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoDomiciliario extends Model
{
    use HasFactory;

    protected $fillable = [
        'afiliado_id',
        'orden_id',
        'referencia_id',
        'consulta_id',
        'vivienda_zona_cobertura',
        'zona_riesgo_accesibilidad',
        'user_criterio_riesgo_id',
        'higiene_afiliado',
        'alimentacion_afiliado',
        'telefono_casa',
        'agua_potable',
        'nevera',
        'luz_electrica',
        'unidad_sanitaria',
        'estabilidad_paciente',
        'barthel',
        'karnofsky',
        'plan_manejo',
        'aceptacion_familia',
        'cumple_criterio',
        'programa',
        'observaciones',
        'estado_id',
        'user_ingreso_id',
    ];
}
