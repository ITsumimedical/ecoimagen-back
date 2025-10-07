<?php

namespace App\Http\Modules\Epidemiologia\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarRespuestaRequest extends FormRequest
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
            'respuestas' => 'array',
            'respuestas.*.id' => 'integer|exists:respuesta_sivigilas,id',
            'respuestas.*.campo_id' => 'integer|exists:campo_sivigilas,id',
            'respuestas.*.consulta_id' => 'integer|exists:consultas,id',
            'respuestas.*.respuesta_campo' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
