<?php

namespace App\Http\Modules\Eventos\AccionesMejora\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\AccionesMejora\Models\AccionesMejoraEvento;
use App\Http\Modules\Eventos\AccionesMejora\Repositories\AccionMejoraRepository;
use App\Http\Modules\Eventos\AccionesMejora\Requests\ActualizarAccionMejoraRequest;
use App\Http\Modules\Eventos\AccionesMejora\Requests\CrearAccionMejoraRequest;
use App\Http\Modules\Eventos\AccionesMejora\Services\AccionMejoraService;
use App\Http\Modules\Eventos\Adjunto\Repositories\AdjuntoEventoAdversoRepository;

class AccionMejoraController extends Controller
{

    public function __construct(
        private AccionMejoraRepository $accionMejoraRepository,
        private AccionMejoraService $accionMejoraService,
        protected AdjuntoEventoAdversoRepository $adjuntoEventoAdversoRepository
    ) {}

    /**
     * crear - crea una acción de mejora
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function crear(CrearAccionMejoraRequest $request): JsonResponse
    {
        try {
            $analisisEvento = $this->accionMejoraService->crearAccionesMejora($request->validated());
            return response()->json($analisisEvento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar($id)
    {
        try {
            $accionMejora = $this->accionMejoraRepository->listarAccionesMejora($id);
            return response()->json($accionMejora, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las acciones de mejora',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarAccionMejoraRequest $request, AccionesMejoraEvento $accionMejoraEvento)
    {
        try {
            $accionMejora = $this->accionMejoraService->actualizarAccion($request, $accionMejoraEvento);
            return response()->json($accionMejora, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al registrar el soporte sobre la acción de mejora',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function actualizarDeletedAt(AccionesMejoraEvento $accionMejoraEvento)
    {
        try {
            $accionMejora = $this->accionMejoraService->actualizarDeletedAt($accionMejoraEvento);

            return response()->json([
                'res' => true,
                'mensaje' => 'Se ha eliminado correctamente el registro',
                'data' => $accionMejora,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al eliminar el registro',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
