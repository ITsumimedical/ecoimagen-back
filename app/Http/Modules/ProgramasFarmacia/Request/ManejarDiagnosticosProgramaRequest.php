<?php

namespace App\Http\Modules\ProgramasFarmacia\Request;

use Illuminate\Foundation\Http\FormRequest;

class ManejarDiagnosticosProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnosticos' => 'required|array',
            'diagnosticos.*' => 'required|integer|exists:cie10s,id',
        ];
    }
}
