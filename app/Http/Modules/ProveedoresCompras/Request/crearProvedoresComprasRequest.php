<?php

namespace App\Http\Modules\ProveedoresCompras\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class crearProvedoresComprasRequest extends FormRequest
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
            'nombre_proveedor' => 'required|string',
            'nit' => 'required|integer',
            'nombre_representante' => 'required|string',
            'telefono' => 'required|integer',
            'direccion' => 'required|string',
            'municipio_id' => 'required|',
            'email' => 'required|string',
            'actividad_economica' => 'required|string',
            'modalidad_vinculacion' => 'required|string',
            'forma_pago' => 'required|string',
            'tiempo_entrega' => 'required|string',
            'area_id' => 'required|integer',
            'tipo_proveedor' => 'required|string',
            'estado' => 'required|boolean',
            'fecha_ingreso' => 'required|date',
            'linea_id' => 'nullable|array',
            'observaciones' => 'nullable|string',
            'files' => 'nullable|array',
            'adjuntoRut' => 'nullable',
            'tipo_documento_legal' => 'required|string',
            'pais_id' => 'required|integer',
            'codigo_dian' => 'required|integer',
            'responsabilidad_fiscal' => 'required|integer'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
