<?php

namespace App\Http\Modules\Telesalud\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RespuestaEspecialistaTelesaludRequest extends FormRequest
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
            'prioridad' => 'required|string',
            'pertinencia_solicitud' => 'required|string',
            'observacion' => 'required|string',
            'finalidad_consulta_id' => 'required|exists:finalidad_consultas,id',
            'causa_externa_id' => 'required|exists:consulta_causa_externas,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
