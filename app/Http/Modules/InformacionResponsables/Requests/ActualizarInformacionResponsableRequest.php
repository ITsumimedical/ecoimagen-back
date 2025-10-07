<?php

namespace App\Http\Modules\InformacionResponsables\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarInformacionResponsableRequest extends FormRequest
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
            'nombre_completo' => 'required|string',
            'telefono' => 'integer',
            'celular' => 'required|integer',
            'direccion' => 'string',
            'parentesco' => 'string|required',
            'ingreso_domiciliario_id' => 'required|integer'
        ];
    }
}
