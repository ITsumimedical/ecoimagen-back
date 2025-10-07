<?php

namespace App\Http\Modules\Consultas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConsultarFirmaTelemedicinaRequest extends FormRequest
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
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'consulta_id' => 'required|integer',    
        ];
    }

    public function faileValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 400)));
    }
}
