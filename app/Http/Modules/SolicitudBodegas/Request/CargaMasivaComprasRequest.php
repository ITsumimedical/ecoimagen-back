<?php

namespace App\Http\Modules\SolicitudBodegas\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CargaMasivaComprasRequest extends FormRequest
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
    public function rules()
    {
        return [
            'archivo' => 'required|file|mimes:xlsx,xls',
        ];
    }

    public function messages()
    {
        return [
            'archivo.required' => 'Debe subir un archivo.',
            'archivo.file' => 'El archivo debe ser válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo Excel (.xlsx o .xls).',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
