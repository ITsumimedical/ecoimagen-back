<?php

namespace App\Http\Modules\Camas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCamaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'created_by' => $user->id,
            'estado_id' => 1
        ]);
    }


    public function rules(): array
    {
        return [
          'nombre' => 'required|string',
          'descripcion' => 'nullable|string',
          'precio' => 'required|numeric',
          'estado_id' => 'required|integer',
          'pabellon_id' => 'required|integer',
          'created_by' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
