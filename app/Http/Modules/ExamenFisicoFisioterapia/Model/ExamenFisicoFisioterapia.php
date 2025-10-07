<?php

namespace App\Http\Modules\ExamenFisicoFisioterapia\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenFisicoFisioterapia extends Model
{
    use HasFactory;

    protected $fillable = [
        'dolor_presente',
        'frecuencia_dolo',
        'intensidad_dolor',
        'edema_presente',
        'ubicacion_edema',
        'sensibilidad_conservada',
        'sensibilidad_alterada',
        'ubicacion_sensibilidad',
        'fuerza_muscular',
        'pruebas_semiologicas',
        'equilibrio_conservado',
        'equilibrio_alterado',
        'marcha_conservada',
        'marcha_alterada',
        'ayudas_externas',
        'consulta_id'
    ];
}
