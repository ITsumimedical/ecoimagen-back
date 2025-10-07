<?php

namespace App\Http\Modules\Interoperabilidad\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearOrdenProcedimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('fecha_vigencia')) {
            // Limpiamos esa cadena extraña porque alguien puso ":AM" como si fuera una decisión válida
            $fechaRaw = str_replace(':AM', 'AM', $this->fecha_vigencia);

            $fecha = \DateTime::createFromFormat('M d Y h:i:sA', $fechaRaw);

            if ($fecha) {
                $this->merge([
                    'fecha_vigencia' => $fecha->format('Y-m-d'),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'orden_id' => 'required|integer',
            'tipo_orden' => 'required|integer',
            'ambito' => 'required|string|in:Hospitalización Domiciliaria,Ambulatorio,Hospilatario,Ambulatorio/Hospilatario',
            'medico_nombre' => 'required|string',
            'medico_documento' => 'nullable|string',
            'medico_registro' => 'nullable|string',
            'medico_especialidad' => 'nullable|integer',
            'finalidad' => 'required|string',
            'procedimiento_id' => 'required|integer',
            'fecha_vigencia' => 'required|date',
            'observacion' => 'required|string',
            'cup_codigo' => 'required|string',
            'rep_codigo_habilitacion' => 'required|string',
            'cantidad' => 'required|integer',
            'estado' => 'required|string',
            'pdf' => 'nullable|string',
            'afiliado' => 'required|array',
            'afiliado.nombre' => 'required|string',
            'afiliado.tipo_documento' => 'required|integer',
            'afiliado.numero_documento' => 'required|string',
        ];
    }

    public function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
