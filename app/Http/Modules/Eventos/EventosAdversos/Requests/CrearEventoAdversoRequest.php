<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEventoAdversoRequest extends FormRequest
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
            'suceso_id' => 'required|exists:sucesos,id',
            'clasificacion_area_id' => 'required_if:suceso_id,161,160,147,139,134,117,116,115,114,113,112,109,20,1',
            'tipo_evento_id' => 'required_if:clasificacion_area_id,27,28,29,30,31,32,33,34,35,36,37,38,67, 84',
            'profesional_id' => 'nullable',
            'fecha_ocurrencia' => 'required|date|before_or_equal:today',
            'dosis' => 'nullable',
            'frecuencia_administracion' => 'nullable',
            'servicio_ocurrencia' => 'nullable|string|required_if:sede_ocurrencia_id,13382', //clínica victoriana
            'servicio_reportante' => 'nullable|string|required_if:sede_reportante_id,13382', //clínica victoriana
            'tiempo_infusion' => 'nullable',
            'medicamento_id' => 'nullable|required_if:suceso_id,109',
            'descripcion_hechos' => 'required|string',
            'accion_tomada' => 'required|string',
            'sede_ocurrencia_id' => 'required|exists:reps,id',
            'sede_reportante_id' => 'required|exists:reps,id',
            'estado_id' => 'required|exists:estados,id',
            'afiliado_id' => 'nullable',
            'user_id' => 'nullable',
            // tecnovigilancia
            'relacion' => 'required_if:suceso_id,139',
            //s'clasif_tecnovigilancia' => 'required_if:suceso_id,139',
            'dispositivo_id' => 'required_if:relacion,Dispositivos,Ambos',
            'referencia_dispositivo' => 'required_if:relacion,Dispositivos,Ambos',
            'marca_dispositivo' => 'required_if:relacion,Dispositivos,Ambos',
            'lote_dispositivo' => 'required_if:relacion,Dispositivos,Ambos',
            'invima_dispositivo' => 'required_if:relacion,Dispositivos,Ambos',
            'fabricante_dispositivo' => 'required_if:relacion,Dispositivos,Ambos',
            'nombre_equipo_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'invima_equipo_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'marca_equipo_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'modelo_equipo_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'serie_equipo_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'fabricante_biomedico' => 'required_if:relacion,Equipo biomédico,Ambos',
            'adjuntos' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
