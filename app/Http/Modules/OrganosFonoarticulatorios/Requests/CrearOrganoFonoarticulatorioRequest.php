<?php

namespace App\Http\Modules\OrganosFonoarticulatorios\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearOrganoFonoarticulatorioRequest extends FormRequest
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
            'lengua' => 'required|string',
            'paladar' => 'required|string',
            'labios' => 'required|string',
            'mucosa' => 'required|string',
            'amigdalas_palatinas' => 'required|string',
            'tono' => 'required|string',
            'timbre' => 'required|string',
            'volumen' => 'required|string',
            'modo_respiratorio' => 'required|string',
            'tipo_respiratorio' => 'required|string',
            'evaluacion_postural' => 'required|string',
            'rendimiento_vocal' => 'required|string',
            'prueba_de_glatzel' => 'required|string',
            'golpe_glotico' => 'required|string',
            'conducto_auditivo_externo' => 'required|string',
            'consulta_id' => 'required|integer|exists:consultas,id',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
