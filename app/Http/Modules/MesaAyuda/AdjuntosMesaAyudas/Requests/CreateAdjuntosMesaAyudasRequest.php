<?php

namespace App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAdjuntosMesaAyudasRequest extends FormRequest
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
            'nombre'        => 'required|string|unique:adjuntos_mesa_ayudas,nombre,' . $this->id . ',id',
            'ruta'          => 'required|string',
            'mesa_ayuda_id' => 'required|int'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
