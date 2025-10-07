<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GenerarZipHistoriasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'medico_id' => $this->input('medico_id') === 'null' ? null : $this->input('medico_id'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fecha_inicio" => "required|date",
            "fecha_final" => "required|date",
            "fecha_corte" => "required|date",
            "file" => "required|file|mimes:xlsx,xls",
            "tipo_historias" => "nullable|array",
            "tipo_historias.*" => "integer", 
            "especialidades" => "nullable|array",
            "especialidades.*" => "integer",
            "medico_id" => 'nullable|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
