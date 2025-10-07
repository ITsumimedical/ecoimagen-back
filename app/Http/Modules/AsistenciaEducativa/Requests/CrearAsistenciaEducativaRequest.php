<?php

namespace App\Http\Modules\AsistenciaEducativa\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CrearAsistenciaEducativaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */


    public function rules(): array
    {
        return [
            'fecha'         => 'date|required',
            'ambito'        => ['integer', Rule::in(['1'])],
            'finalidad'     => ['integer', Rule::in(['4'])],
            'cup_id'        => 'integer|required|exists:cups,id',
            'tema'          => 'string|required',
            'afiliado_id'   => 'integer|required|exists:afiliados,id'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'ambito' => $this->ambito ?? '1',
            'finalidad' => $this->finalidad ?? '4'
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

