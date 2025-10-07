<?php

namespace App\Http\Modules\Epidemiologia\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarRespuestaRequest extends FormRequest
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
            'respuestas' => 'required|array',
            'respuestas.*.campo_id' => 'required|integer|exists:campo_sivigilas,id',
            'respuestas.*.consulta_id' => 'required|integer|exists:consultas,id',
            'respuestas.*.respuesta_campo' => 'nullable',
            'respuestas.*.pais_id' => 'nullable|integer',
            'respuestas.*.departamento_id' => 'nullable|integer',
            'respuestas.*.municipio_id' => 'nullable|integer',
            'eventoId' => 'required|integer|exists:evento_sivigilas,id',
            'consultaId' => 'required|integer|exists:consultas,id',
            'cie10Id' => 'required|integer|exists:cie10s,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
