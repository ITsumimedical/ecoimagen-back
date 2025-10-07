<?php

namespace App\Http\Modules\CodigoPropios\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCodigoPropioRequest extends FormRequest
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
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:codigo_propios,codigo',
            'genero' => 'required|string',
            'edad_inicial' => 'required|numeric',
            'edad_final' => 'required|numeric',
            'quirurgico' => 'required|numeric',
            'diagnostico_requerido' => 'required|numeric',
            'nivel_ordenamiento' => 'required|numeric',
            'nivel_portabilidad' => 'nullable',
            'requiere_auditoria' => 'required|numeric',
            'periodicidad' => 'required|numeric',
            'cantidad_max_ordenamiento' => 'required|numeric',
            'ambito_id' => 'required|exists:ambitos,id',
            'cup_id' => 'required|exists:cups,id',
            'valor' => 'required|numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
