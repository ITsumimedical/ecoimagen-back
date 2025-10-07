<?php

namespace App\Http\Modules\Interoperabilidad\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearOrdenMedicamentoRequest extends FormRequest
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
            'orden_medicamento_id' => 'required|integer',
            'rep_codigo_habilitacion' => 'required|string',
            'medicamento_codigo' => 'required|string',
            'medicamento_nombre' => 'required|string',
            'estado' => 'required|integer',
            'dosis' => 'required|integer',
            'frecuencia' => 'required|integer',
            'unidad_tiempo' => 'required|string',
            'duracion' => 'required|integer',
            'via' => 'required|string',
            'cantidad_mensual' => 'required|integer',
            'cantidad_mensual_disponible' => 'required|integer',
            'cantidad_medico' => 'required|integer',
            'observacion' => 'required|string',
            'fecha_vigencia' => 'required|date',
            'pdf' => 'nullable|string',
            'afiliado' => 'required|array',
            'afiliado.nombre' => 'required|string',
            'afiliado.tipo_documento' => 'required|integer',
            'afiliado.numero_documento' => 'required|string',
            'meses' => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}