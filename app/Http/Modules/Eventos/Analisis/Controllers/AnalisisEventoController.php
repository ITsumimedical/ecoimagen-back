<?php

namespace App\Http\Modules\Eventos\Analisis\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\Analisis\Repositories\AnalisisEventoRepository;
use App\Http\Modules\Eventos\Analisis\Requests\ActualizarAnalisisEventoRequest;
use App\Http\Modules\Eventos\Analisis\Requests\CrearAnalisisEventoRequest;
use App\Http\Modules\Eventos\Analisis\Services\AnalisisEventosService;

class AnalisisEventoController extends Controller
{

    public function __construct(
        protected AnalisisEventoRepository $analisisEventoAdversoRepository,
        protected AnalisisEventosService $analisisEventoService
    ) {}

    /**
     * Guarda un análisis de un evento adverso
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearAnalisisEventoRequest $request): JsonResponse
    {
        try {
            $analisisEvento = $this->analisisEventoService->crearActualizarEventoAnalisis($request->validated());
            return response()->json($analisisEvento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarAnalisisEventoRequest $request, AnalisisEvento $id)
    {
        try {
            $this->analisisEventoAdversoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
