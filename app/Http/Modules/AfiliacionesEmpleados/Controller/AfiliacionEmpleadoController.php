<?php

namespace App\Http\Modules\AfiliacionesEmpleados\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AfiliacionesEmpleados\Models\AfiliacionEmpleado;
use App\Http\Modules\AfiliacionesEmpleados\Request\CrearAfiliacionEmpleadoRequest;
use App\Http\Modules\AfiliacionesEmpleados\Repositories\AfiliacionEmpleadoRepository;
use App\Http\Modules\AfiliacionesEmpleados\Request\ActualizarAfiliacionEmpleadoRequest;
class AfiliacionEmpleadoController extends Controller
{
    private $afiliacionEmpleadoRepository;

    public function __construct(){
        $this->afiliacionEmpleadoRepository = new AfiliacionEmpleadoRepository;
    }

    /**
     * lista las afiliaciones de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $afiliacion = $this->afiliacionEmpleadoRepository->listarAfiliacionEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $afiliacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las afiliaciones del contrato',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una afiliacion de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearAfiliacionEmpleadoRequest $request):JsonResponse{
        try {
            $afiliacion = $this->afiliacionEmpleadoRepository->crear($request->validated());
            return response()->json($afiliacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una afiliacion de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarAfiliacionEmpleadoRequest $request, AfiliacionEmpleado $id){
        try {
            $this->afiliacionEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * desafiliar - termina la afiliación de un empleado en una entidad
     *
     * @param  mixed $afiliacion
     * @return void
     */
    public function desafiliar(AfiliacionEmpleado $afiliacion){
        try {
            $afiliacion->desafiliar();
            return response()->json($afiliacion, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }
}
