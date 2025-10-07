<?php

namespace App\Http\Modules\Camas\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearNovedadCamaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'created_by' => $user->id,
        ]);
    }


    public function rules(): array
    {
        return [
            'descripcion' => 'required|string',
            'tipo_id' => 'required|integer',
            'cama_id' => 'required|integer',
            'created_by' => 'required|integer'
        ];
    }
}
