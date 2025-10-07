<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Requests;

use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCodesumiEntidadRequest extends FormRequest
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
            'codesumi_id' => 'required|exists:codesumis,id',
            'entidad_id' => 'required|exists:entidades,id',
            'requiere_autorizacion' => 'required|boolean',
            'nivel_ordenamiento' => 'required',
            'estado_normativo' => 'required',
            'requiere_mipres' => 'required|boolean'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
