<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Requests;

use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CodesumiEntidadRequest extends FormRequest
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
            'entidad_id' => 'required|array',
            'entidad_id.*' => 'exists:entidades,id',
            'requiere_autorizacion' => 'required|boolean',
            'nivel_ordenamiento' => 'required',
            'estado_normativo' => 'required',
            'programas' => 'nullable|array',
            'programas.*' => 'integer',
            'requiere_mipres' => 'required|boolean'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->entidad_id && $this->codesumi_id) {
                foreach ($this->entidad_id as $entidadId) {
                    $exists = CodesumiEntidad::where('codesumi_id', $this->codesumi_id)
                        ->where('entidad_id', $entidadId)
                        ->exists();

                    if ($exists) {
                        $validator->errors()->add('codesumi_id', 'El codesumi_id ya está parametrizado para esta entidad: ' . $entidadId);
                    }
                }
            }
        });
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
