<?php

namespace App\Http\Modules\respuestasTest\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CrearRespuestasTestRequest extends FormRequest
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
            'respuestas' => 'required|array', // Validar que 'respuestas' sea un array
            'respuestas.*.consulta_id' => 'required|exists:consultas,id', // Validar que cada 'consulta_id' exista en la tabla 'consultas'
            'respuestas.*.pregunta_id' => 'required|exists:preguntas_tipo_tests,id', // Validar que cada 'pregunta_id' exista en la tabla 'preguntas_tipo_test'
            'respuestas.*.respuesta' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
