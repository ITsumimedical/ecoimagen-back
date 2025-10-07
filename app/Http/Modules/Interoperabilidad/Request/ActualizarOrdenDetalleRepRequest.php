<?php

namespace App\Http\Modules\Interoperabilidad\Request;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarOrdenDetalleRepRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $rep_codigo_habilitacion = $this->input('rep_codigo');
        $rep = Rep::where('codigo', $rep_codigo_habilitacion)->first();
        # Aquí haces el merge para agregar o modificar campos
        $this->merge([
            'rep_id' => $rep->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rep_id' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
