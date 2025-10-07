<?php

namespace App\Http\Modules\Empalme\requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEmpalmeRequest extends FormRequest
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
            'acepta_represa'            => 'string|required',
            'tutela'                    => 'string|required',
            'tipo_servicio'             => 'string|required',
            'cie10s_id'                 => 'integer|required|exists:cie10s,id',
            'afiliado_id'               => 'integer|required|exists:afiliados,id',
            'empalme'                   => 'boolean',
            'observaciones_contratista' => 'string',
            'fecha_solicitud'           => 'date|required',
            'cup_id'                    => 'integer|nullable|exists:cups,id',
            'codesumi_id'               => 'integer|nullable|exists:codesumis,id',
            'codigo_propio_id'          => 'integer|nullable|exists:codigo_propios,id',
            'anexos'                    => 'string',
            'adjuntos'                  => 'required',

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'empalme' => true,
        ]);
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
