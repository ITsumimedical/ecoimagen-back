<?php

namespace App\Http\Modules\Tarifas\Requests;

use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AgregarCupTarifaRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        $array = [
            'cup_id' => 'required|exists,cups,id'
        ];

        # buscamos la tarifa para validar su tipo de manual
        $tarifa = Tarifa::where('id', $this->tarifa_id)->first();
        $manualesTarifariosConValor = [4, 5, 6];

        # en caso de pertenecer se agrega el campo valor que se vuelve obligatorio
        if(in_array($tarifa->manual_tarifario_id, $manualesTarifariosConValor)){
            $array['valor'] = 'required|numeric';
        }

        return $array;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
