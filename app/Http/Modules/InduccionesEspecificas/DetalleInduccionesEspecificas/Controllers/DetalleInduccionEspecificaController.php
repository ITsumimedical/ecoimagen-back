<?php

namespace App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Models\DetalleInduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Repositories\DetalleInduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Requests\ActualizarDetalleInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Requests\CrearDetalleInduccionEspecificaRequest;

class DetalleInduccionEspecificaController extends Controller
{
    private $detalleInduccionRepository;

    public function __construct(){
        $this->detalleInduccionRepository = new DetalleInduccionEspecificaRepository;
    }

    /**
     * lista los detalles de inducciones especificas de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar($id): JsonResponse
    {
        $induccion = $this->detalleInduccionRepository->listarConInduccion($id);
        try {
            return response()->json([
                'res' => true,
                'data' => $induccion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'err' => $th->getMessage(),
                'mensaje' => 'Error al listar los detalles de inducciones',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un detalle induccion específica para un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearDetalleInduccionEspecificaRequest $request):JsonResponse{
        try {
            $detalleInduccion = $this->detalleInduccionRepository->crear($request->validated());
            return response()->json($detalleInduccion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un detalle de inducción específicas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarDetalleInduccionEspecificaRequest $request, DetalleInduccionEspecifica $id){
        try {
            $this->detalleInduccionRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
