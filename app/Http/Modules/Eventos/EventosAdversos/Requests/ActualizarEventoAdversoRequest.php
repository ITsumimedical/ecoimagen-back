<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarEventoAdversoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'=> 'nullable',
            'suceso_id' => 'required',
            'tipo_evento_id' => 'required_if:clasificacion_area_id,27,28,29,30,31,32,33,34,35,36,37,38,67, 84',
            'clasificacion_area_id' => 'required_if:suceso_id,161,160,147,139,134,117,116,115,114,113,112,109,20,1',
            'fecha_ocurrencia' => 'nullable',
            'fecha_reporte' => 'nullable',
            'servicio_ocurrencia' => 'nullable',
            'servicio_reportante' => 'nullable',
            'descripcion_hechos' => 'required',
            'accion_tomada' => 'required',
            'estado_id' => 'required',
            // asignar
            'voluntariedad' => 'boolean|nullable',
            'priorizacion' => 'nullable|required_if:asignar,true',
            'identificacion_riesgo' => 'nullable|required_if:asignar,true',
            // anular
            'motivo_anulacion_id' => 'nullable|required_if:anular,true',
            'clasificacion_anulacion' => 'nullable|required_if:motivo_anulacion_id,4,5,6,7',
            'otros_motivo_anulacion' => 'nullable|required_if:motivo_anulacion_id,7',
            'sede_reportante_id' => 'nullable',
            'sede_ocurrencia_id' => 'nullable',
            // dispositivos y equipo biomedico
            'dispositivo_id' => 'nullable',
            'referencia_dispositivo' => 'nullable',
            'marca_dispositivo' => 'nullable',
            'lote_dispositivo' => 'nullable',
            'invima_dispositivo' => 'nullable',
            'fabricante_dispositivo' => 'nullable',
            'nombre_equipo_biomedico' => 'nullable',
            'marca_equipo_biomedico' => 'nullable',
            'modelo_equipo_biomedico' => 'nullable',
            'serie_equipo_biomedico' => 'nullable',
            'invima_equipo_biomedico' => 'nullable',
            'fabricante_biomedico' => 'nullable',
            'relacion' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
