<?php

namespace App\Http\Modules\ConsentimientosInformados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearConsentimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(){
        $laboratorio = $this->input('laboratorio');
        $odontologia = $this->input('odontologia');

        $this->merge([
            'laboratorio' => filter_var($laboratorio,FILTER_VALIDATE_BOOLEAN)
            ,'odontologia' => filter_var($odontologia,FILTER_VALIDATE_BOOLEAN)
        ]);
    }

    public function rules(): array
    {
        return [
            'cupId' => 'required|unique:consentimientos_informados,cup_id',
            'nombre' => 'required',
            'descripcion' => 'required',
            'beneficios' => 'required',
            'riesgos' => 'required',
            'alternativas' => 'required',
            'riesgo_no_aceptar' => 'required',
            'informacion' => 'required',
            'recomendaciones' => 'required',
            'codigo' => 'required',
            'version' => 'required',
            'fecha_aprobacion' => 'required',
            'laboratorio' => 'required|boolean',
            'odontologia' => 'required|boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function attributes()
    {
        return [
            'cup_id' => 'Cup'
        ];
    }
}
