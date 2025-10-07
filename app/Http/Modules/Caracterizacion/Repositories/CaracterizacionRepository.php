<?php

namespace App\Http\Modules\Caracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Caracterizacion\Models\Caracterizacion;

class CaracterizacionRepository extends RepositoryBase
{

    public function __construct(protected Caracterizacion $caracterizacionModel)
    {
        parent::__construct($this->caracterizacionModel);
    }

    public function ListarCaracterizacion($afiliado_id)
    {
        return $this->caracterizacionModel->select(
            'caracterizaciones.id',
            'caracterizaciones.zona_vivienda',
            'caracterizaciones.residencia',
            'caracterizaciones.correo',
            'caracterizaciones.conforman_hogar',
            'caracterizaciones.tipo_vivienda',
            'caracterizaciones.hogar_con_agua',
            'caracterizaciones.cocina_con',
            'caracterizaciones.energia',
            'caracterizaciones.accesibilidad_vivienda',
            'caracterizaciones.etnia',
            'caracterizaciones.escolaridad',
            'caracterizaciones.orientacion_sexual',
            'caracterizaciones.oficio_ocupacion',
            'caracterizaciones.metodo_planificacion',
            'caracterizaciones.planeando_embarazo',
            'caracterizaciones.citologia_ultimo_año',
            'caracterizaciones.tamizaje_tamografia',
            'caracterizaciones.tamizaje_prostata',
            'caracterizaciones.autocuidado',
            'caracterizaciones.victima_volencia',
            'caracterizaciones.victima_desplazamiento',
            'caracterizaciones.consumo_sustancias_psicoavtivas',
            'caracterizaciones.consume_alcohol',
            'caracterizaciones.actividad_fisica',
            'caracterizaciones.antecedentes_cancer_familia',
            'caracterizaciones.antecedentes_enfermedades_metabolicas_familia',
            'caracterizaciones.diagnosticos_salud_mental',
            'caracterizaciones.antecedente_cancer',
            'caracterizaciones.antecedentes_enfermedades_metabolicas',
            'caracterizaciones.antecedentes_enfermedades_riego_cardiovascular',
            'caracterizaciones.enfermedades_respiratorias',
            'caracterizaciones.enfermedades_inmunodeficiencia',
            'caracterizaciones.medicamentos_uso_permanente',
            'caracterizaciones.antecedente_hospitalizacion_cronica',
            'caracterizaciones.antecedentes_riesgo_individualizado',
            'caracterizaciones.alteraciones_nutricionales',
            'caracterizaciones.enfermedades_infecciosas',
            'caracterizaciones.cancer',
            'caracterizaciones.trastornos_visuales',
            'caracterizaciones.problemas_salud_mental',
            'caracterizaciones.enfermedades_zonoticas',
            'caracterizaciones.trastornos_degenerativos',
            'caracterizaciones.trastorno_consumo_psicoactivas',
            'caracterizaciones.enfermedad_cardiovascular',
            'caracterizaciones.trastornos_auditivos',
            'caracterizaciones.trastornos_salud_bucal',
            'caracterizaciones.accidente_enfermedad_laboral',
            'caracterizaciones.violencias',
            'caracterizaciones.respiratorias_cronicas',
            'caracterizaciones.usuario_registra_id',
            'caracterizaciones.departamento_residencia_id',
            'caracterizaciones.municipio_residencia_id',
            'caracterizaciones.estrato',
            'caracterizaciones.estado_civil',
            'caracterizaciones.seguridad_orden',
            'caracterizaciones.tipo_violencia',
            'caracterizaciones.violencia_sexual',
            'caracterizaciones.violencia_no_sexual',
            'caracterizaciones.frecuencia_consumo_sustancias_psicoactivas',
            'caracterizaciones.frecuencia_consumo_alcohol',
            'caracterizaciones.conflicto_armado',
            'caracterizaciones.tipo_conflicto_armado',
            'caracterizaciones.frecuencia_actividad_fisica',
            'caracterizaciones.created_at',
            'afiliados.id as afiliado_id',
            'afiliados.sexo'
        )
            ->join('afiliados', 'caracterizaciones.afiliado_id', 'afiliados.id')
            ->where('caracterizaciones.afiliado_id', $afiliado_id)
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ', afiliados.segundo_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_apellido) as nombreAfiliado")
            ->latest('caracterizaciones.created_at')
            ->first();
    }
}
