<?php

namespace App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarDetalleProgramacionMensualRequest extends FormRequest
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
            'programacion_mensual_id' => 'required|exists:programacion_mensual_ths,id',
            'dia' => 'required|integer',
            'turno_id' => 'required|exists:turno_ths,id',
            'etiqueta_id' => 'required|exists:etiqueta_ths,id',
            'servicio_id' => 'required|exists:servicio_ths,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
