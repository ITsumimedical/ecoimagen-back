<?php

namespace App\Http\Modules\testSrq\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearSrqRequest extends FormRequest
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
            'dolor_cabeza_frecuente' => 'string|required',
            'mal_apetito' => 'string|required',
            'duerme_mal' => 'string|required',
            'asusta_facilidad' => 'string|required',
            'temblor_manos' => 'string|required',
            'nervioso_tenso' => 'string|required',
            'mala_digestion' => 'string|required',
            'pensar_claridad' => 'string|required',
            'siente_triste' => 'string|required',
            'llora_frecuencia' => 'string|required',
            'dificultad_disfrutar' => 'string|required',
            'tomar_decisiones' => 'string|required',
            'dificultad_hacer_trabajo' => 'string|required',
            'incapaz_util' => 'string|required',
            'interes_cosas' => 'string|required',
            'inutil' => 'string|required',
            'idea_acabar_vida' => 'string|required',
            'cansado_tiempo' => 'string|required',
            'estomago_desagradable' => 'string|required',
            'cansa_facilidad' => 'string|required',
            'herirlo_forma' => 'string|required',
            'importante_demas' => 'string|required',
            'voces' => 'string|required',
            'convulsiones_ataques' => 'string|required',
            'demasiado_licor' => 'string|required',
            'dejar_beber' => 'string|required',
            'beber_trabajo' => 'string|required',
            'detenido_borracho' => 'string|required',
            'bebia_demasiado' => 'string|required',
            'consulta_id' => 'required|exists:consultas,id',
            'interpretacion_resultado' => 'string|nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
