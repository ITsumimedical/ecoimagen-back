<?php

namespace App\Http\Modules\Incapacidades\Services;

use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Incapacidades\Models\Incapacidade;
use App\Http\Modules\Incapacidades\Repositories\IncapacidadRepository;
use Illuminate\Support\Facades\Auth;

class IncapacidadService
{
    public function __construct(protected IncapacidadRepository $incapacidadRepository) {
    }

    public function registrar($request) {
        $request['usuario_realiza_id'] = Auth::id();
        return $this->incapacidadRepository->crear($request);
    }

    public function anularIncapacidad($request){
        $incapacidad = Incapacidade::findOrFail($request->incapacidad_id);
        $incapacidad->estado_id = 5;
        $incapacidad->save();

        CambiosOrdene::create([
            'user_id' => Auth::id(),
            'incapacidad_id' => $request->incapacidad_id,
            'accion' => 'Anulación de incapacidad desde histórico',
            'observacion' => $request->observacion,
        ]);

        return response()->json(['message' => 'Se ha anulado la incapacidad correctamente!.']);
    }

    public function editarFechaIncapacidad($request) {
        $incapacidad = Incapacidade::find($request->id);

        // Guardar las fechas actuales de la incapacidad antes de realizar cualquier actualización
        $fechaInicioAnterior = $incapacidad->fecha_inicio;
        $fechaFinalAnterior = $incapacidad->fecha_final;

        $actualizar = [];

        // Comprobar si el request contiene una nueva fecha de inicio y si esta es diferente de la fecha de inicio actual
        if (isset($request['fecha_inicio']) && $request['fecha_inicio'] !== $fechaInicioAnterior) {
            $actualizar['fecha_inicio'] = $request['fecha_inicio'];
        }

        // Comprobar si el request contiene una nueva fecha final y si esta es diferente de la fecha final actual
        if (isset($request['fecha_final']) && $request['fecha_final'] !== $fechaFinalAnterior) {
            $actualizar['fecha_final'] = $request['fecha_final'];
        }

        // Si hay campos que necesitan ser actualizados
        if (!empty($actualizar)) {
            // Actualizar la incapacidad con los nuevos valores
            $incapacidad->update($actualizar);

            // Crear la observación para registrar los cambios
            $observacion = '';
            if (isset($actualizar['fecha_inicio'])) {
                $observacion .= "Fecha inicial anterior: $fechaInicioAnterior -> Nueva fecha inicial: {$actualizar['fecha_inicio']}. ";
            }

            if (isset($actualizar['fecha_final'])) {
                $observacion .= "Fecha final anterior: $fechaFinalAnterior -> Nueva fecha final: {$actualizar['fecha_final']}.";
            }

            // Registrar los cambios en la tabla cambios_ordenes
            CambiosOrdene::create([
                'observacion' => trim($observacion),
                'estado' => 1,
                'user_id' => Auth::id(),
                'accion' => 'Actualización de fechas de incapacidad',
                'incapacidad_id' => $incapacidad->id,
            ]);
        }

        return $incapacidad;
    }


}
