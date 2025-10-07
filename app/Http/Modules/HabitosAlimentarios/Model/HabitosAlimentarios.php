<?php

namespace App\Http\Modules\HabitosAlimentarios\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitosAlimentarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'lactando_actualmente',
        'lactancia_materna_exclusiva',
        'postura_madre_niño',
        'agarre',
        'succion',
        'madre_reconoce_hambre_saciedad_bebe',
        'necesidades_madre_lactancia_materna',
        'recibio_preparacion_prenatal',
        'suministra_leche_hospitalario_neonatal',
        'expectativas_madre_familia',
        'frecuencia_lactancia',
        'duracion_lactancia',
        'dificultades_lactancia_materna',
        'madre_extrae_conserva_leche',
        'como_realiza_extraccion_conservacion_leche',
        'alimentado_leche_formula',
        'inicio_alimentos_agua_otra_bebida',
        'durante_dia_ayer_recibio_liquidos',
        'durante_dia_recibio_leche',
        'durante_dia_recibio_leche_vaca',
        'durante_dia_recibio_sopa',
        'edad_meses_diferentes_alimentos',
        'consumo_dieta_familiar',
        'cuantas_comidas_dia',
        'consumo_5_porciones_frutas',
        'dieta_balanceada_baja_azucares',
    ];
}
