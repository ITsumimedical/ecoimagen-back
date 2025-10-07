<?php

namespace App\Http\Modules\Tutelas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListarAccionRequest extends FormRequest
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
        $accion = [
            'filtro'=>'nullable|required',
            'paginacion' => 'required'
           
            
        ];
        foreach($this->input('filtro') as $filtro) {
            if($filtro == ' filtro'){
                $accion['estado_id'] = 'nullable|required';
                $accion['cedula_paciente'] = 'nullable|required';
                $accion['entidad_id'] = 'nullable|required';
                $accion['radicado'] = 'nullable|required';
                $accion['municipio'] = 'nullable|required';
                $accion['fecha_inicio'] = 'nullable|required';
                $accion['fecha_fin'] = 'nullable|required';
            }
            if($filtro == 'paginacion'){
                $accion['pagina'] = 'required';
                $accion['cantidadRegistros'] = 'required';
                $accion['total'] = 'required';
            }   


        return $accion;
        };
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }



}