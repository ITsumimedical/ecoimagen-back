<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPqrsfAutogestionRequest extends FormRequest
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
            'quien_genera' => 'required|string',
            'documento_genera' => 'required|string',
            'nombre_genera' => 'required|string',
            'correo' => 'required|string',
            'telefono' => 'required|string',
            'descripcion' => 'required|string',
            'canal_id' => 'required|integer',
            'tipo_solicitud_id' => 'required|integer',
            'afiliado_id' => 'required|integer',
            'usuario_registra_id' => 'required|integer',
            'adjuntos' => 'nullable|array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
