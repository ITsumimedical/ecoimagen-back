<?php

namespace App\Http\Modules\CampoHistorias\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\CampoHistorias\Services\CampoHistoriaService;
use App\Http\Modules\CampoHistorias\Requests\CrearCampoHistoriasRequest;
use App\Http\Modules\CampoHistorias\Repositories\CampoHistoriaRepository;
use App\Http\Modules\CampoHistorias\Requests\ActualizarCampoHistoriasRequest;

class CampoHistoriasController extends Controller
{
    private $campoHistoriaRepository;
    private $campoHistoriaService;
    public function __construct(CampoHistoriaRepository $campoHistoriaRepository, CampoHistoriaService $campoHistoriaService){
       $this->campoHistoriaRepository = $campoHistoriaRepository;
       $this->campoHistoriaService = $campoHistoriaService;
    }

    /**
     * lista los campos de la historia
     * @param Request $request
     * @return Response
     * @author JDSS
     */
    public function listar(Request $request)
    {
        try {
            $campoHistoria = $this->campoHistoriaRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' =>$campoHistoria
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los campos de la historia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un campo de historia
     * @param Request $request
     * @return Response $campoHistoria
     * @author JDSS
     */
    public function crear(CrearCampoHistoriasRequest $request): JsonResponse
    {
        try {
            // $nuevoCampoHistoria = new CampoHistoria($request->all());
            $campoHistoria = $this->campoHistoriaService->guardarCampo($request->all());
            return response()->json([
                'res' => true,
                'data' => $campoHistoria,
                'mensaje' => 'Se creó el campo para la historia con éxito.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el campo para la historia!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un campo para la historia
     * @param Request $request
     * @param int $id
     * @return Response $campoHistoria
     * @author JDSS
     */
    public function actualizar(ActualizarCampoHistoriasRequest $request, int $id): JsonResponse
    {
        try {
            $actualizarcampoHistoria = $this->campoHistoriaService->actualizarCampo($request->all(),$id);
            return response()->json([
                'res' => true,
                'data' => $actualizarcampoHistoria,
                'mensaje' => 'El campo para la historia fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el campo para la historia!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
