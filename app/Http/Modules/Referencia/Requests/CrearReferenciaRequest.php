<?php

namespace App\http\Modules\Referencia\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearReferenciaRequest extends FormRequest
{
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
            'tipo_anexo' => 'required|string',
            'especialidad_remision' => 'required|string',
            'tipo_solicitud' => 'string',
            'codigo_remision' => 'string|nullable',
            'afiliado_id' => 'required|integer',
            'descripcion' => 'string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

