<?php

namespace App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Repositories\CompromisoInduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Requests\CrearCompromisoInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Repositories\SeguimientoCompromisoInduccionEspecificaRepository;

class CompromisoInduccionEspecificaController extends Controller
{
    private $compromisoInduccionRepository;
    private $seguimientoCompromisoInduccionRepository;

    public function __construct(){
        $this->compromisoInduccionRepository = new CompromisoInduccionEspecificaRepository;
        $this->seguimientoCompromisoInduccionRepository = new SeguimientoCompromisoInduccionEspecificaRepository;
    }

    /**
     * lista los compromisos de las inducciones especificas de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar($id)
    {
        try {
            $compromiso = $this->compromisoInduccionRepository->listarCompromiso($id);
            return response()->json([
                'res' => true,
                'data' => $compromiso
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los compromisos de la inducción específica',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un compromiso de una induccion específica de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearCompromisoInduccionEspecificaRequest $request):JsonResponse{
        try {
            $induccion = $this->compromisoInduccionRepository->crear($request->validated());
            $seguimientoCompromiso = $this->seguimientoCompromisoInduccionRepository->crearSeguimiento($induccion->id);
            return response()->json($seguimientoCompromiso, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
