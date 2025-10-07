<?php

namespace App\Http\Modules\Telesalud\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Telesalud\Repositories\TelesaludRepository;
use App\Http\Modules\Telesalud\Requests\CrearTelesaludRequest;
use App\Http\Modules\Telesalud\Requests\RespuestaEspecialistaTelesaludRequest;
use App\Http\Modules\Telesalud\Requests\RespuestaJuntaTelesaludRequest;
use App\Http\Modules\Telesalud\Services\TelesaludService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TelesaludController extends Controller
{
    private $telesaludService;
    private $telesaludRepository;

    public function __construct(TelesaludService $telesaludService, TelesaludRepository $telesaludRepository)
    {
        $this->telesaludService = $telesaludService;
        $this->telesaludRepository = $telesaludRepository;
    }

    /**
     * Metodo para crear un registro de telesalud
     * @param CrearTelesaludRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function crearTelesalud(CrearTelesaludRequest $request): JsonResponse
    {
        try {
            $telesalud = $this->telesaludService->crearTelesalud($request->validated());
            return response()->json([
                'res' => true,
                'mensaje' => 'Telesalud creada correctamente',
                'data' => $telesalud
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la telesalud',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Metodo para listar las telesalud pendientes
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function listarPendientes(Request $request)
    {
        try {
            $respuesta = $this->telesaludRepository->listarPendientes($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para listar los detalles de una telesalud pendiente
     * @param int $telesaludId
     * @return JsonResponse
     * @author Thomas
     */
    public function listarDetallesTelesalud(int $telesaludId)
    {
        try {
            $telesalud = $this->telesaludRepository->listarDetallesTelesalud($telesaludId);
            return response()->json($telesalud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar la telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para actualizar la especialidad de una telesalud
     * @param int $telesaludId
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarEspecialidad(int $telesaludId, Request $request)
    {
        try {
            $telesalud = $this->telesaludService->actualizarEspecialidad($telesaludId, $request->all());
            return response()->json($telesalud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para responder una telesalud
     * @param int $telesaludId
     * @param RespuestaEspecialistaTelesaludRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function respuestaEspecialista(int $telesaludId, RespuestaEspecialistaTelesaludRequest $request)
    {
        try {
            $telesalud = $this->telesaludService->respuestaEspecialista($telesaludId, $request->validated());
            return response()->json($telesalud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al responder la telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para listar las telesalud solucionadas
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function listarSolucionadas(Request $request)
    {
        try {
            $respuesta = $this->telesaludRepository->listarSolucionadas($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para listar las telesalud pendientes de junta profesionales
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function listarJuntaPendientes(Request $request)
    {
        try {
            $respuesta = $this->telesaludRepository->listarJuntaPendientes($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para responder una telesalud de junta de profesionales
     * @param int $telesaludId
     * @param RespuestaJuntaTelesaludRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function respuestaJunta(int $telesaludId, RespuestaJuntaTelesaludRequest $request)
    {
        try {
            $telesalud = $this->telesaludService->respuestaJunta($telesaludId, $request->validated());
            return response()->json($telesalud, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al responder la telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para listar las telesalud solucionadas de junta profesionales
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function listarJuntaSolucionadas(Request $request)
    {
        try {
            $respuesta = $this->telesaludRepository->listarJuntaSolucionadas($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las telesalud'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
