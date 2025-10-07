<?php

namespace App\Http\Modules\Indicadores\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarDatosIndicadorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'clasificacion_ca_priorizado' => 'nullable|string',
            'departamento' => 'nullable|string',
            'municipio' => 'nullable|string',
            'ips' => 'nullable|string',
            'entidad' => 'nullable|string',
            'tipo_documento' => 'nullable|string',
            'documento' => 'nullable|string',
            'nombre_usuario' => 'nullable|string',
            'sexo' => 'nullable|string',
            'edad_momento_diagnostico' => 'nullable|string',
            'ciclo_vida' => 'nullable|string',
            'primera_consulta_medico_ordena' => 'nullable|string',
            'fecha_consulta_inicial_medico_ordena_biopsia' => 'nullable|string',
            'fecha_Autorizacion_biopsia' => 'nullable|string',
            'fecha_toma_muestra_biopsia' => 'nullable|string',
            'fecha_ingreso_biopsia' => 'nullable|string',
            'fecha_salida_biopsia_reporte' => 'nullable|string',
            'fecha_diagnostico_patologia_inicial' => 'nullable|string',
            'fecha_diagnosticos_ihq' => 'nullable|string',
            'fecha_diagnostico_pos_operatorio' => 'nullable|string',
            'fecha_diagnostico_por_iht_pos_operatorio' => 'nullable|string',
            'fecha_reporte_laboratorio' => 'nullable|string',
            'fecha_solicitud_primera_consulta_ingreso_programa_oncologia' => 'nullable|string',
            'fecha_primera_consulta_ingreso_programa_oncologia' => 'nullable|string',
            'oportunidad_ingreso_programa_oncologia_medico_superviviente' => 'nullable|string',
            'fecha_solicitud_primera_consulta_Especialista_tratante' => 'nullable|string',
            'fecha_primera_consulta_especialista_tratante' => 'nullable|string',
            'oportunidad_desde_dx_hasta_Evaluacion_especialista' => 'nullable|string',
            'especialidad' => 'nullable|string',
            'prestador' => 'nullable|string',
            'mes' => 'nullable|string',
            'anio' => 'nullable|string',
            'cie10' => 'nullable|string',
            'descripcion_cie10' => 'nullable|string',
            'agrupado_didier' => 'nullable|string',
            'tipo_inicio_tto_mono_poli_cx' => 'nullable|string',
            'tnm' => 'nullable|string',
            'escala_gleason' => 'nullable|string',
            'estadio' => 'nullable|string',
            'tipo_cirugia_conservadora_ca_mama' => 'nullable|string',
            'riesgo_aplica_prostata' => 'nullable|string',
            'clasificacion_ann_arbor_lugano' => 'nullable|string',
            'rh_estrogenos' => 'nullable|string',
            'rh_progestagenos' => 'nullable|string',
            'ki_67' => 'nullable|string',
            'her_2' => 'nullable|string',
            'tto_hormonal' => 'nullable|string',
            'tto_anti_her2' => 'nullable|string',
            'remision_consulta_radioterapia' => 'nullable|string',
            'fecha_inicio_radioterapia' => 'nullable|string',
            'fecha_inicio_braquiterapia' => 'nullable|string',
            'ips_direccionamiento_radioterapia' => 'nullable|string',
            'fecha_remision_medicina_dolor' => 'nullable|string',
            'fecha_programa_cita_dolor' => 'nullable|string',
            'estado_consulta' => 'nullable|string',
            'remite_cx_torax' => 'nullable|string',
            'fecha_primera_Consulta_cirugia_torax' => 'nullable|string',
            'remision_oncologia_hemato_oncologia' => 'nullable|string',
            'fecha_primera_consulta_oncologia_hemato_oncologia' => 'nullable|string',
            'remision_mastologia' => 'nullable|string',
            'fecha_primera_consulta_mastologia' => 'nullable|string',
            'remite_cx_palstica' => 'nullable|string',
            'fecha_primera_consulta_cirugia_plastica' => 'nullable|string',
            'fecha_ordena_primer_tto' => 'nullable|string',
            'fecha_inicia_primer_tto' => 'nullable|string',
            'oportunidad_inicio_tto' => 'nullable|string',
            'fecha_ordena_primer_tratamiento_pos' => 'nullable|string',
            'fecha_inicio_tto_pos' => 'nullable|string',
            'oportunidad_tto_pos_cx' => 'nullable|string',
            'fecha_ordena_primer_tratamiento_neoadyuvante' => 'nullable|string',
            'fecha_inicio_tto_neoadyuvante' => 'nullable|string',
            'oportunidad_neoadyuvante' => 'nullable|string',
            'estado_afiliado' => 'nullable|string',
            'observaciones_generales' => 'nullable|string',
            'control_psa' => 'nullable|string',
            'disentimiento' => 'nullable|boolean',
            'clasificacion_riesgo_internacional_lh_lnh' => 'nullable|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
