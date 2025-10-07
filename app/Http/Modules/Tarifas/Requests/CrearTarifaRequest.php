<?php

namespace App\Http\Modules\Tarifas\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CrearTarifaRequest extends FormRequest
{
    private $manualTarifarioConValor = [4, 5, 6];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rep_id' => 'required|exists:reps,id',
            'manual_tarifario_id' => 'required|numeric|exists:manual_tarifarios,id',
            'etiqueta' => 'required|string|max:255',
            'contrato_id' => 'required|exists:contratos,id',
            'pleno' => 'required|boolean',
            'valor' => 'nullable|numeric',
            'cantiad_personas' => 'nullable|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
