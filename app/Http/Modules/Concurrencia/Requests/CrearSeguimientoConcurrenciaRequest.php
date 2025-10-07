<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearSeguimientoConcurrenciaRequest extends FormRequest
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
            'notas' => 'nullable',
            'nota_dss' => 'nullable',
            'nota_aac' => 'nullable',
            'nota_lc' => 'nullable',
            'concurrencia_id' => 'nullable',
            'user_id' => 'nullable',
            'user_notadss_id' => 'nullable',
            'user_notaaac_id' => 'nullable',
            'user_notalc_id' => 'nullable',
            'nota_ingreso' => 'nullable',
        ];
    }
}
