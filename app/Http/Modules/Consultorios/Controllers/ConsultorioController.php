<?php

namespace App\Http\Modules\Consultorios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\Consultorios\Services\ConsultorioService;
use App\Http\Modules\Consultorios\Requests\CrearConsultorioRequest;
use App\Http\Modules\Consultorios\Requests\FiltroConsultorioRequest;
use App\Http\Modules\Consultorios\Repositories\ConsultorioRepository;
use App\Http\Modules\Consultorios\Requests\ActualizarConsultorioRequest;

class ConsultorioController extends Controller
{
    protected ConsultorioRepository $consultorioRepository;
    protected ConsultorioService $consultorioServicio;

    public function __construct(ConsultorioService $consultorioService)
    {
        $this->consultorioRepository = new ConsultorioRepository;
        $this->consultorioServicio = $consultorioService;
    }

    /**
     * lista los consultorios
     * @param Request $request
     * @return Response
     * @author leon
     */
     public function listar(FiltroConsultorioRequest $request): JsonResponse
    {
        try {
            $consultorios = $this->consultorioServicio->consultorios($request->validated());
            return response()->json($consultorios);
        } catch (\Throwable $e) {
            return response()->json([
                'mensaje' => 'Error al recuperar los consultorios',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guarda un consultorio
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearConsultorioRequest $request):JsonResponse
    {
        try {
            $nuevoConsultorio = new Consultorio($request->all());
            $consultorio = $this->consultorioRepository->guardar($nuevoConsultorio);
            return response()->json([
                'res' => true,
                'data' => $consultorio,
                'mensaje' => 'Consultorio creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el consultorio',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id): JsonResponse
    {
       try {
        $consultorio = $this->consultorioRepository->buscar($id);
        $consultorio->fill($request->all());
        $actualizarConsultorio = $this->consultorioRepository->guardar($consultorio);
        return response()->json([
            'res' => true,
            'data' => $actualizarConsultorio,
            'mensaje' => 'consultorio actualizado con exito!.'
        ], Response::HTTP_OK);
       } catch (\Throwable $th) {
        return response()->json([
            'res' => false,
            'mensaje' => 'Error al actualizar consultorio!'
        ], Response::HTTP_BAD_REQUEST);
       }
    }

    public function listarRep(Request $request){
        try {
            $consultorios = $this->consultorioRepository->listarRep($request->rep_id);
            return response()->json($consultorios, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al recuperar los consultorios'
            ], 400);
        }
    }
}
