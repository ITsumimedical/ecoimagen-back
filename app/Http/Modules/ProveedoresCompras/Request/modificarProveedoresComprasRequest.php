<?php

namespace App\Http\Modules\ProveedoresCompras\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class modificarProveedoresComprasRequest extends FormRequest
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
            'nombre_proveedor' => 'nullable|string',
            'nit' => 'nullable|integer',
            'nombre_representante' => 'nullable|string',
            'telefono' => 'nullable|integer',
            'direccion' => 'nullable|string',
            'municipio_id' => 'nullable|',
            'email' => 'nullable|string',
            'actividad_economica' => 'nullable|string',
            'modalidad_vinculacion' => 'nullable|string',
            'forma_pago' => 'nullable|string',
            'tiempo_entrega' => 'nullable|string',
            'area_id' => 'nullable|integer',
            'tipo_proveedor' => 'nullable|string',
            'estado' => 'nullable|boolean',
            'fecha_ingreso' => 'nullable|date',
            'linea_id' => 'nullable|integer',
            'operador_seleccionado' => 'nullable|integer',
            'observaciones' => 'nullable|string',
            'files' => 'nullable|array',
            'adjuntoRut' => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
