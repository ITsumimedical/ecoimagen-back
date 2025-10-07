<?php

namespace App\Http\Modules\Medicamentos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class FiltroPrestadoresRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio' => 'required|integer',
            'mes' => 'required|integer',
            'estado' => 'nullable|integer',
            'documento' => 'nullable|string',
            'sede' => 'required|array',
            'orden_id' => 'nullable|integer',
            'servicioClinica' => 'nullable|string',
            'perPage'=>'required|integer',
            'page'=>'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
