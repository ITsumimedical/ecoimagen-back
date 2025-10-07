<?php

namespace App\Http\Modules\AdjuntosAyudasDiagnosticos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearAdjuntosAyudasDiagnosticosRequest extends FormRequest
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
            'nombre' => 'required|string',
            'ruta' => 'required|string',
            'resultado_ayudas_diagnosticas_id' => 'required|integer|exists:resultado_ayudas_diagnosticas,id',
        ];
    }
}
