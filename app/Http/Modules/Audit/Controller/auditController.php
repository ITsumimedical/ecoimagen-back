<?php

namespace App\Http\Modules\Audit\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Audit\Repositories\auditRepository;
use App\Http\Modules\Audit\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class auditController extends Controller
{
    public function __construct(
        private auditRepository $auditRepository,
        private AuditService $auditService,
    ) {}

    public function crear(Request $request)
    {
        try {
            $data = $request->all();

            $this->auditService->updateOrCreate(
                ['consulta_id' => $data['consulta_id']],
                $data
            );

            return response()->json('Creado o actualizado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function obtenerDatos($afiliadoId)
    {
        try {
            $audit = $this->auditRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($audit, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
