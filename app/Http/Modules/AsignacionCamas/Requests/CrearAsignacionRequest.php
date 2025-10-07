<?php

namespace App\Http\Modules\AsignacionCamas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAsignacionRequest extends FormRequest
{

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

    public function rules(): array
    {
        return [
            'fecha' => 'required|date',
            'tipo_cama' => 'required|string',
            'cama_id'   => 'required|integer',
            'admision_urgencia_id' => 'required|integer',
            'created_by' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
