<?php

namespace App\Http\Modules\Clientes\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ClienteRequest extends FormRequest
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
            'user_id'=>'nullable',
            'name'=>'required|string|min:4|max:255',
            'correo'=>'required|email',
            'secret'=>'nullable',
            'provider'=>'nullable',
            'redirect'=>'nullable',
            'personal_access_client'=>'nullable',
            'password_client'=>'nullable',
            'revoked'=>'nullable'
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
