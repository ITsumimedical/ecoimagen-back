<?php

namespace App\Http\Modules\TipoLicenciasEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoLicenciasEmpleados\Models\TipoLicenciaEmpleado;
use App\Http\Modules\TipoLicenciasEmpleados\Repositories\TipoLicenciaRepository;
use App\Http\Modules\TipoLicenciasEmpleados\Requests\ActualizarTipoLicenciaRequest;
use App\Http\Modules\TipoLicenciasEmpleados\Requests\CrearTipoLicenciaRequest;

class TipoLicenciaController extends Controller
{
    private $tipoLicenciaRepository;

    public function __construct(){
        $this->tipoLicenciaRepository = new TipoLicenciaRepository;
    }

    /**
     * lista los tipos de licencias
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $tipoLicencia = $this->tipoLicenciaRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoLicencia
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de licencias',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de licencia
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTipoLicenciaRequest $request):JsonResponse{
        try {
            $tipoLicencia = $this->tipoLicenciaRepository->crear($request->validated());
            return response()->json($tipoLicencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de licencia
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTipoLicenciaRequest $request, TipoLicenciaEmpleado $id){
        try {
            $this->tipoLicenciaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
