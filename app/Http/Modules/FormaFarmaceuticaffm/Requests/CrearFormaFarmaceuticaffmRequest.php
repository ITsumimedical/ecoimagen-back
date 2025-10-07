<?php

namespace App\Http\Modules\FormaFarmaceuticaffm\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearFormaFarmaceuticaffmRequest extends FormRequest
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
            'codigo' => 'required|string|min:3',
            'nombre' => 'required|string',
            'habilitado' => 'required|boolean',
            'nombre_abreviado' => 'required|string|min:2'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'habilitado' => true,
        ]);
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
