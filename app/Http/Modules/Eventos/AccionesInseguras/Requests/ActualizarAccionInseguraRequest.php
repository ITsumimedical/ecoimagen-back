<?php

namespace App\Http\Modules\Eventos\AccionesInseguras\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarAccionInseguraRequest extends FormRequest
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
            'nombre' => 'nullable',
            'condiciones_paciente' => 'nullable',
            'metodos' => 'nullable',
            'colaborador' => 'nullable',
            'equipo_trabajo' => 'nullable',
            'ambiente' => 'nullable',
            'recursos' => 'nullable',
            'contexto' => 'nullable',
            'analisis_evento_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
