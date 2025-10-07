<?php

namespace App\Http\Modules\Rips\Configuracion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracione extends Model
{
    use HasFactory;

    protected $fillable = [
        'salario_minimo_actual',
        'cuota_moderadora_nivel_1',
        'cuota_moderadora_nivel_2',
        'cuota_moderadora_nivel_3',
        'porcentaje_copago_nivel_1',
        'porcentaje_copago_nivel_2',
        'porcentaje_copago_nivel_3',
        'valor_tope_copago_nivel_1_servicio',
        'valor_tope_copago_nivel_2_servicio',
        'valor_tope_copago_nivel_3_servicio',
        'valor_tope_copago_nivel_1_anio',
        'valor_tope_copago_nivel_2_anio',
        'valor_tope_copago_nivel_3_anio',
        'porcentaje_copago_subsidiado',
        'valor_tope_copago_subsidiado_servicio',
        'valor_tope_copago_subsidiado_anio',
        'fecha_inicio_habilitacion_validador_202',
        'fecha_fin_habilitacion_validador_202',
        'excepcion_habilitacion_validador_202',
        'dia_inicio_habilitacion_validador_rips',
        'dia_final_habilitacion_validador_rips',
        'excepcion_habilitacion_validador_rips',
    ];
}
