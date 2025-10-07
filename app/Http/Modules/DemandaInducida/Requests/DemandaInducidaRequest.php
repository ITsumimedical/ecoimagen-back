<?php

namespace App\Http\Modules\DemandaInducida\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DemandaInducidaRequest extends FormRequest
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
            'tipo_demanda_inducida'             => 'string|required',
            'programa_remitido'                 => 'string|required',
            'fecha_dx_riesgo_cardiovascular'    => 'date|nullable',
            'descripcion_evento_salud_publica'  => 'string|nullable',
            'descripcion_otro_programa'         => 'string|nullable',
            'observaciones'                     => 'string|required',
            'demanda_inducida_efectiva'         => 'boolean',
            'afiliado_id'                       => 'integer|required|exists:afiliados,id',
            'consulta_1_id'                     => 'integer|nullable',
            'consulta_2_id'                     => 'integer|nullable',
            'consulta_3_id'                     => 'integer|nullable',
            'fecha_registro'                    => 'date|required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
