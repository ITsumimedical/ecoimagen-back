<?php

namespace App\Http\Modules\ResultadoAyudasDiagnosticos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Repositories\ResultadoAyudasDiagnosticasRepository;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Services\ResultadoAyudaDIagnosticosService;
use Illuminate\Http\Request;

class  ResultadoAyudasDiagnosticasController extends Controller
{
    public function __construct(
        protected ResultadoAyudasDiagnosticasRepository $resultadoAyudasDiagnosticasRepository, protected ResultadoAyudaDIagnosticosService $resultadoAyudaDiagnosticosService
    ) {}

    public function crear(Request $request)
    {
        try {
            $ayudas = $this->resultadoAyudaDiagnosticosService->guardarAyudasDiagnosticos($request->all());
            return response()->json(['Creado con exito', $ayudas]);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 400);
        }
    }

    public function listarAyudasDiagnosticas($afiliado_id)
    {
        try {
            $ayudas = $this->resultadoAyudasDiagnosticasRepository->listarAyudasDiagnosticasAfiliado($afiliado_id);
            return response()->json($ayudas);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            $this->resultadoAyudasDiagnosticasRepository->eliminarAyudaDiagnostica($id);
            return response()->json(['message' => 'Eliminado con éxito'], 200);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 400);
        }
    }
}
