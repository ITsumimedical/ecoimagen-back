<?php

namespace App\Http\Modules\Interoperabilidad;

use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Illuminate\Support\Facades\Storage;

class InteroperabilidadOrdenesService {

    public function __construct()
    {}

    /**
     * actualiza el estado de un orden articulo
     * @param array $data
     * @return OrdenProcedimiento
     * @author David Peláez
     */
    public function actualizarOrdenDetalle(array $data, OrdenProcedimiento|int $detalle){
        # buscamos el orden detalle
        if(!$detalle instanceof OrdenProcedimiento){
            $detalle = OrdenProcedimiento::where('id', $data['id'])->first();
        }
        # actualizamos el detalle
        $detalle->update($data);
        Storage::append('auditoria_fomag_ordenes.txt', json_encode([
            'date' => now(),
            'procedimiento' => $detalle,
            'data' => $data
        ]));
        return [
            'mensaje' => 'el procedimiento se actualizo correctamente.'
        ];
    }

    /**
     * actualiza el envio de una orden
     * @param Orden|int $orden
     * @return bool
     * @author David Peláez
     */
    public function respuestaTranscripcion(Orden|int $orden): bool{
        if (!$orden instanceof Orden) {
            $orden = Orden::where('id', $orden)->firstOrFail();
        }
        # actualizamos el estado de la orden
        return $orden->update([
            'enviado' => true
        ]);
    }
}