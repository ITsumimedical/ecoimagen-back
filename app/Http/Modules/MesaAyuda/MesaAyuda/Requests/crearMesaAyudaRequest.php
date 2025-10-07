<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class crearMesaAyudaRequest extends FormRequest
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
            'plataforma'              => 'nullable',
            'usuario_registra_id'     => 'nullable',
            'asunto'                  => 'required',
            'contacto'                => 'required|string',
            'clasificacion'           => 'required|string',
            'descripcion'             => 'required',
            'categoria_mesa_ayuda_id' => 'required|exists:categoria_mesa_ayudas,id',
            'prioridad_id'            => 'nullable|exists:prioridades,id',
            'sede_id'                 => 'required|exists:sedes,id',
            'adjuntos'=>'nullable'

        ];
    }

    public function attributes()
    {
        return [
            'categoria_mesa_ayuda_id' => 'categoria',
            'prioridad_id'            => 'prioridad',
            'sede_id'                 => 'sede',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
