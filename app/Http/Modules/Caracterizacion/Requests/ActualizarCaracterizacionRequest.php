<?php

namespace App\Http\Modules\Caracterizacion\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCaracterizacionRequest extends FormRequest
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
            'afiliado_id'                                               => 'integer|required|exists:afiliados,id',
            'tipo_vivienda'                                             => 'string|required',
            'orientacion_sexual'                                        => 'string|required',
            'oficio_ocupacion'                                          => 'string|required',
            'actividad_fisica'                                          => 'string|required',
            'enfermedades_inmunodeficiencia'                            => 'string|required',
            'economia_articular'                                        => 'string|required',


        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
