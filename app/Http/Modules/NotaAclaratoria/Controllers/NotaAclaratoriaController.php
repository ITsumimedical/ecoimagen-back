<?php

namespace App\Http\Modules\NotaAclaratoria\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\NotaAclaratoria\Services\NotaAclaratoriaService;
use App\Http\Modules\NotaAclaratoria\Repositories\NotaAclaratoriaRepository;

class NotaAclaratoriaController extends Controller
{

    public function __construct(private NotaAclaratoriaRepository $notaAclaratoriaRepository,private NotaAclaratoriaService $notaAclaratoriaService
    ) {}

    public function crear(Request $request): JsonResponse
    {
        try {
            $CategoriaMesaAyuda = $this->notaAclaratoriaService->guardar($request->all());
            return response()->json($CategoriaMesaAyuda, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una categoria de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request): JsonResponse
    {
        try {
            $CategoriaMesaAyuda = $this->notaAclaratoriaRepository->listarNota($request->all());
            return response()->json($CategoriaMesaAyuda, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una categoria de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
