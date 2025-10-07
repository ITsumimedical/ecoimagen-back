<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearClienteMesaAyudaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255|unique:Clientes_Mesa_Ayuda,nombre',
            'endpoin_pendientes' => 'required|string',
            'endpoin_accion_gestionado' => 'required|string',
            'endpoin_accion_comentario_solicitante' => 'required|string',
            'endpoin_accion_reasignar' => 'required|string',
            'endpoin_accion_solucionar' => 'required|string',
        ];
    }
}
