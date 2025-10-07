<?php

namespace App\Http\Modules\CodigoServicio\Request;

use Illuminate\Foundation\Http\FormRequest;

class CrearCodigoServicioRequest extends FormRequest
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
            'codigo' => 'string|required',
            'nombre' => 'string|required',
            'descripcion' => 'string|required',
            'estado_id' => 'integer|required|exists:estados,id',
        ];
    }
}
