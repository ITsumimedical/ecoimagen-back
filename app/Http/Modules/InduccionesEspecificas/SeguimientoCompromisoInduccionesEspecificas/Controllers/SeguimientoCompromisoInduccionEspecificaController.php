<?php

namespace App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Models\SeguimientoCompromisoInduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Repositories\SeguimientoCompromisoInduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Requests\ActualizarSeguimientoCompromisoInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Requests\CrearSeguimientoCompromisoInduccionEspecificaRequest;

class SeguimientoCompromisoInduccionEspecificaController extends Controller
{
    private $seguimientoCompromisoRepository;

    public function __construct(){
        $this->seguimientoCompromisoRepository = new SeguimientoCompromisoInduccionEspecificaRepository;
    }

    /**
     * lista los seguimientos de los compromisos derivados de inducciones especificas de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar($id)
    {
        try {
            $compromiso = $this->seguimientoCompromisoRepository->listarSeguimiento($id);
            return response()->json([
                'res' => true,
                'data' => $compromiso
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los seguimientos a compromisos de la inducción específica',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una induccion específica para un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearSeguimientoCompromisoInduccionEspecificaRequest $request):JsonResponse{
        try {
            $induccion = $this->seguimientoCompromisoRepository->crear($request->validated());
            return response()->json($induccion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una inducción específica
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarSeguimientoCompromisoInduccionEspecificaRequest $request, SeguimientoCompromisoInduccionEspecifica $id){
        try {
            $this->seguimientoCompromisoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

}
