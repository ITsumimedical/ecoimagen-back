<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class actualizarMesaAyudaRequest extends FormRequest
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
            'asunto' => 'required|string',
            'descripcion' => 'required|string',
            'user_id' => 'required|integer',
            'categoria_mesa_ayuda_id' => 'required|integer',
            'prioridad_id' => 'nullable|integer',
            'sede_id' => 'required|integer',
            'estado_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
