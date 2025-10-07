<?php

namespace App\Http\Modules\Caracterizacion\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class CrearCaracterizacionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'afiliado_id'                                               => 'integer|required|exists:afiliados,id',
            'zona_vivienda'                                             => 'string',
            'residencia'                                                => 'string',
            'correo'                                                    => 'string',
            'conforman_hogar'                                           => 'string',
            'tipo_vivienda'                                             => 'string|required',
            'hogar_con_agua'                                            => 'boolean',
            'cocina_con'                                                => 'string|required',
            'energia'                                                   => 'string',
            'accesibilidad_vivienda'                                    => 'string',
            'etnia'                                                     => 'string|required',
            'escolaridad'                                               => 'string|required',
            'orientacion_sexual'                                        => 'string|required',
            'oficio_ocupacion'                                          => 'string|required',
            'metodo_planificacion'                                      => 'string',
            'planeando_embarazo'                                        => 'string',
            'citologia_ultimo_año'                                      => 'string',
            'tamizaje_tamografia'                                       => 'string',
            'tamizaje_prostata'                                         => 'string',
            'autocuidado'                                               => 'string',
            'victima_volencia'                                          => 'string|required',
            'victima_desplazamiento'                                    => 'string',
            'consumo_sustancias_psicoavtivas'                           => 'string',
            'consume_alcohol'                                           => 'string',
            'actividad_fisica'                                          => 'string|required',
            'antecedentes_cancer_familia'                               => 'string',
            'antecedentes_enfermedades_metabolicas_familia'             => 'string',
            'diagnosticos_salud_mental'                                 => 'string',
            'antecedente_cancer'                                        => 'string|required',
            'antecedentes_enfermedades_metabolicas'                     => 'string',
            'antecedentes_enfermedades_riego_cardiovascular'            => 'string',
            'enfermedades_respiratorias'                                => 'string|required',
            'enfermedades_inmunodeficiencia'                            => 'string|required',
            'medicamentos_uso_permanente'                               => 'string',
            'antecedente_hospitalizacion_cronica'                       => 'string',
            'antecedentes_riesgo_individualizado'                       => 'string',
            'alteraciones_nutricionales'                                => 'string',
            'enfermedades_infecciosas'                                  => 'string',
            'cancer'                                                    => 'string',
            'trastornos_visuales'                                       => 'string',
            'problemas_salud_mental'                                    => 'string',
            'enfermedades_zonoticas'                                    => 'string',
            'trastornos_degenerativos'                                  => 'string',
            'trastorno_consumo_psicoactivas'                            => 'string',
            'enfermedad_cardiovascular'                                 => 'string',
            'trastornos_auditivos'                                      => 'string',
            'trastornos_salud_bucal'                                    => 'string',
            'accidente_enfermedad_laboral'                              => 'string',
            'violencias'                                                => 'string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
