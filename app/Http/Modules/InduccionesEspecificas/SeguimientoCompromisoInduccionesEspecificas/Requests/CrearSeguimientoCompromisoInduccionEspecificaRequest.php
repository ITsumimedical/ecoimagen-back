<?php

namespace App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearSeguimientoCompromisoInduccionEspecificaRequest extends FormRequest
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
            'compromiso_induccion_especifica_id' => 'exists:compromiso_induccion_especificas,id',
            'estado_id' => 'exists:estados,id',
            'nota_adicional' => 'string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
