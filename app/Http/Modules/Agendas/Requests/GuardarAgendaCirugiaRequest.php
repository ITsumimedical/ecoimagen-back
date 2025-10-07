<?php

namespace App\Http\Modules\Agendas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarAgendaCirugiaRequest extends FormRequest
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
            'afiliado_id' => 'required',
            'clase' => 'required',
            'cup_id' => 'required',
            'rep_id' => 'required',
            'quirofano_id' => 'required',
            'fecha_cirugia' => 'required',
            'hora_inicio_estimada' => 'required',
            'hora_fin_estimada' => 'required',
            'colorSeleccionado' => 'required',
            'tipo_anestesia' => 'required',
            'cirujano' => 'required',
            'especialidad_cirujano' => 'required',
            'anestesiologo' => 'nullable',
            'fecha_aval_cirugia' => 'nullable',
            'aval_cirugia' => 'nullable',
            'observacion_negacion_aval_cirugia' => 'nullable',
            'orden_procedimiento_id' => 'nullable',
            'orden_id' => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
