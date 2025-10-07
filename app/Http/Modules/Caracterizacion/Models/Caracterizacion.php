<?php

namespace App\Http\Modules\Caracterizacion\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Departamentos\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracterizacion extends Model
{
    use HasFactory;
    protected $table = 'caracterizaciones';

    protected $fillable = [
        'afiliado_id',
        'zona_vivienda',
        'residencia',
        'correo',
        'conforman_hogar',
        'tipo_vivienda',
        'hogar_con_agua',
        'cocina_con',
        'energia',
        'accesibilidad_vivienda',
        'etnia',
        'escolaridad',
        'orientacion_sexual',
        'oficio_ocupacion',
        'metodo_planificacion',
        'planeando_embarazo',
        'citologia_ultimo_año',
        'tamizaje_tamografia',
        'tamizaje_prostata',
        'autocuidado',
        'victima_volencia',
        'victima_desplazamiento',
        'consumo_sustancias_psicoavtivas',
        'consume_alcohol',
        'actividad_fisica',
        'antecedentes_cancer_familia',
        'antecedentes_enfermedades_metabolicas_familia',
        'diagnosticos_salud_mental',
        'antecedente_cancer',
        'antecedentes_enfermedades_metabolicas',
        'antecedentes_enfermedades_riego_cardiovascular',
        'enfermedades_respiratorias',
        'enfermedades_inmunodeficiencia',
        'medicamentos_uso_permanente',
        'antecedente_hospitalizacion_cronica',
        'antecedentes_riesgo_individualizado',
        'alteraciones_nutricionales',
        'enfermedades_infecciosas',
        'cancer',
        'trastornos_visuales',
        'problemas_salud_mental',
        'enfermedades_zonoticas',
        'trastornos_degenerativos',
        'trastorno_consumo_psicoactivas',
        'enfermedad_cardiovascular',
        'trastornos_auditivos',
        'trastornos_salud_bucal',
        'accidente_enfermedad_laboral',
        'violencias',
        'respiratorias_cronicas',
        'usuario_registra_id',
        'departamento_residencia_id',
        'municipio_residencia_id',
        'estrato',
        'estado_civil',
        'seguridad_orden',
        'tipo_violencia',
        'violencia_sexual',
        'violencia_no_sexual',
        'frecuencia_consumo_sustancias_psicoactivas',
        'frecuencia_consumo_alcohol',
        'conflicto_armado',
        'tipo_conflicto_armado',
        'frecuencia_actividad_fisica',

    ];


    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function departamentos()
    {
        return $this->belongsTo(Departamento::class);
    }
}
