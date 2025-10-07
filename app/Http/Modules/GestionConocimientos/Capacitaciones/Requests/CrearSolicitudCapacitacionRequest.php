<?php

namespace App\Http\Modules\GestionConocimientos\Capacitaciones\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearSolicitudCapacitacionRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'tipo_requerimiento' => 'required',
            'fuente' => 'required',
            'otro_fuente' => 'required_if:fuente,Otro',
            'descripcion' => 'required',
            'usuario_registra_id' => 'required|exists:users,id',
            'estado_id' => 'required|exists:estados,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
