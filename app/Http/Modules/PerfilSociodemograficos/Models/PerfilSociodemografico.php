<?php

namespace App\Http\Modules\PerfilSociodemograficos\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerfilSociodemografico extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'instituciones_ahorro' => 'array',
        'actividades_gustaria_hacer' => 'array',
        'areas_estudios_interes' => 'array',
        'aspectos_gasta_dinero' => 'array',
        'barreras_uso_tiempo_libre' => 'array',
        'personas_comparte_tiempo' => 'array',
        'uso_tiempo_libre' => 'array',
        'tiene_mascota' => 'boolean',
        'fuma' => 'boolean',
        'bebidas_alcoholicas' => 'boolean',
        'sustancias_psicoactivas' => 'boolean',
        'alergico_medicamento' => 'boolean',
        'sufre_enfermedad' => 'boolean',
        'vacunas_ultimo_anio' => 'boolean',
        'refuerzo_vacunas_ultimo_anio' => 'boolean',
        'salud_oral_ultimo_anio' => 'boolean',
        'metodo_planificacion_familiar' => 'boolean',
        'examen_agudeza_visual_ultimo_anio' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
