<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarAdmisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'parentesco_responsable' => 'nullable',
            'telefono_responsable' => 'nullable',
            'nombre_responsable' => 'nullable',
            'correo2'=> 'nullable',
            'correo1' => 'required|email',
            'direccion_residencia_barrio' => 'nullable',
            'direccion_residencia_cargue' => 'nullable',
            'celular2' => 'nullable',
            'celular1' => 'required',
            'telefono' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
