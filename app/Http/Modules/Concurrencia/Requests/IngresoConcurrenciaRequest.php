<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IngresoConcurrenciaRequest extends FormRequest
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
            'afiliado_id' => 'required|integer',
            'fecha_ingreso' => 'required|date',
            'cie10_id' => 'required|integer',
            'tipo_hospitalizacion' => 'required|string|max:255',
            'via_ingreso' => 'required|string|max:255',
            'reingreso_15_dias' => 'required|string',
            'reingreso_30_dias' => 'required|string',
            'rep_id' => 'required|integer',
            'cama_piso' => 'nullable|string|max:255',
            'codigo_habilitacion' => 'nullable|string|max:255',
            'estancia_total' => 'nullable|string|max:255',
            'especialidad_id' => 'required|integer',
            'nota_seguimiento' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
