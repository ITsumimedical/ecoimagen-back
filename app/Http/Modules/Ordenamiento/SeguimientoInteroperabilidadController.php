<?php

namespace App\Http\Modules\Ordenamiento;

use App\Http\Controllers\Controller;
use App\Http\Modules\Ordenamiento\Requests\AsignarDiagnosticoRequest;
use App\Http\Modules\Ordenamiento\Services\SeguimientoInteroperabilidadService;
use Illuminate\Http\Request;

class SeguimientoInteroperabilidadController extends Controller {

    public function __construct(
        protected SeguimientoInteroperabilidadService $seguimientoInteroperabilidadService
    ){}
    /**
     * lista los logs de interoperabilidad
     */
    public function listar(Request $request) {
        try {
            $logs = $this->seguimientoInteroperabilidadService->listar($request->all());
            return response()->json($logs, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * lista los logs de interoperabilidad
     */
    public function asignarDiagnostico(AsignarDiagnosticoRequest $request) {
        try {
            $logs = $this->seguimientoInteroperabilidadService->asignarDiagnostico($request->validated());
            return response()->json($logs, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

}