<?php

namespace App\Http\Modules\EstudiosEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEstudioEmpleadoRequest extends FormRequest
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
            'titulo_obtenido' => 'required|string',
            'nivel_estudio' => 'required|string',
            'institucion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_graduacion' => 'required|date',
            'prerrogativa' => 'boolean|nullable',
            'descripcion_prerrogativa' => 'required_if:prerrogativa,true',
            'empleado_id' => 'exists:empleados,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
