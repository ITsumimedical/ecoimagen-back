<?php

namespace App\Http\Modules\Tutelas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarTutelaRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
        'radicado' => 'required|string',
        'fecha_radica' => 'required|date',
        'fecha_cerrada' => 'date',
        'observacion'=> 'required|string',
        'afiliado_id' => 'required',
        'municipio_id' => 'required',
        'juzgado_id' => 'required',
        'estado_id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
