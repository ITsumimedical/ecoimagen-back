<?php

namespace App\Http\Modules\RespuestasTutelas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\RespuestasTutelas\Models\RespuestaTutela;
use App\Http\Modules\RespuestasTutelas\Repositories\RespuestaTutelaRepository;
use App\Http\Modules\RespuestasTutelas\Requests\ActualizarRespuestaTutelaRequest as RequestsActualizarRespuestaTutelaRequest;
use App\Http\Modules\RespuestasTutelas\Requests\GuardarRespuestaTutelaRequest;
use App\Http\Modules\RespuestasTutelas\Services\RespuestaTutelaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RespuestaTutelaController extends Controller
{
    public function __construct(protected RespuestaTutelaRepository $respuestaTutelaRepository, protected RespuestaTutelaService $respuestaTutelaService) {}

    /**
     * listar las respuestas
     * @param Request $request
     * @return Response $respuesta
     * @author Arles Garcia
     */

    public function listarRespuestas(Request $request)
    {
        try {
            $respuesta = $this->respuestaTutelaRepository->listarRespuestas($request);
            return response()->json($respuesta);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las respuestas'
            ], 400);
        }
    }

     /**
     * Almacena una respuesta
     * @param Request $request
     * @return Response $respuestas
     * @author Arles Garcia
     */

    public function crear(GuardarRespuestaTutelaRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->respuestaTutelaService->guardarRespuesta($request->all());
            return response()->json($respuesta, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar la respuesta tutelas'
            ], 400);
        }
    }

     /**
     * actualiza una respuesta
     * @param Request $request
     * @return Response $respuestasTutela
     * @author Arles Garcia
     */

    public function actualizar(RequestsActualizarRespuestaTutelaRequest $request, RespuestaTutela $Respuesta)
    {
        try {
            $respuestaTutela = $this->respuestaTutelaRepository->actualizar($Respuesta,$request->validated());
            return response()->json($respuestaTutela, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar respuestas'
            ], 400);
        }
    }

    public function consultarAdjuntos(Request $request)
    {
        try {
            $adjuntosRespuesta = $this->respuestaTutelaRepository->consultarAdjuntos($request);
            return response()->json($adjuntosRespuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los adjuntos'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }
}
