<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarDatosContactoRequest extends FormRequest
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
            'telefono' => 'required|string',
            'celular1' => 'required|string',
            'celular2' => 'nullable|string',
            'correo1' => 'required|string',
            'correo2' => 'nullable|string',
            'direccion_residencia_cargue' => 'nullable|string',
            'direccion_residencia_via' => 'nullable|string',
            'direccion_residencia_numero_interior' => 'nullable|string',
            'direccion_residencia_interior' => 'nullable|string',
            'direccion_residencia_numero_exterior' => 'nullable|string',
            'direccion_residencia_barrio' => 'nullable|string',
            'dpto_residencia_id' => 'nullable|integer',
            'mpio_residencia_id' => 'nullable|integer',
            'nombre_responsable' => 'nullable',
            'telefono_responsable' => 'nullable',
            'parentesco_responsable' => 'nullable'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
