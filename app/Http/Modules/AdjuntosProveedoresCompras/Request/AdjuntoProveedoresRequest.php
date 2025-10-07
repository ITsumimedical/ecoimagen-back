<?php

namespace App\Http\Modules\AdjuntosProveedoresCompras\Request;

use Illuminate\Foundation\Http\FormRequest;

class AdjuntoProveedoresRequest extends FormRequest
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
            "nombre"=> "required|string",
            "ruta_adjunto"=> "required|string",
            "tipo_adjunto"=> "nullable|array",
            "proveedor_id"=> "required|integer",
        ];
    }
}
