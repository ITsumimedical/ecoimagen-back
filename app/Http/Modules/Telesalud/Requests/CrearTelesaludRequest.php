<?php

namespace App\Http\Modules\Telesalud\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTelesaludRequest extends FormRequest
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
            'tipo_estrategia_id' => 'required|integer',
            'tipo_solicitud_id' => 'required|integer',
            'especialidad_id' => 'required|integer',
            'motivo' => 'required|string',
            'resumen_hc' => 'required|string',
            'afiliado_id' => 'required|integer',
            'numero_documento' => 'required|string',
            'diagnostico_principal' => 'required|integer',
            'diagnosticos' => 'nullable|array',
            'adjuntos' => 'nullable|array',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
