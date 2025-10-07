<?php

namespace App\Http\Modules\Reportes\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearReporteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'created_by' => $user->id
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
            'nombre_reporte' => 'required|string|max:255',
            'nombre_procedimiento' => 'required|string|max:255',
            'parametros' => 'required|array',
            'parametros.*.nombre_parametro' => 'required|string|max:255',
            'parametros.*.orden_parametro' => 'required|integer',
            'parametros.*.tipo_dato' => 'required|string|max:50',
            'parametros.*.origen' => 'nullable|string|max:255',
            'parametros.*.nombre_columna_bd' => 'nullable|string|max:255',
            'parametros.*.valor_columna_guardar' => 'nullable|string|max:255',
            'created_by' => 'required'
        ];
    }

    /**
     * Mensajes personalizados ya que necesito mostrarlos en el front
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'parametros.*.nombre_parametro.required' => 'El nombre del parámetro es obligatorio.',
            'parametros.*.orden_parametro.required' => 'El orden del parámetro es obligatorio.',
            'parametros.*.tipo_dato.required' => 'El tipo de dato es obligatorio.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
