<?php

namespace App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Models\InduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Repositories\InduccionEspecificaRepository;
use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Requests\ActualizarInduccionEspecificaRequest;
use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Requests\CrearInduccionEspecificaRequest;

class InduccionEspecificaController extends Controller
{
    private $induccionRepository;

    public function __construct(){
        $this->induccionRepository = new InduccionEspecificaRepository;
    }

    /**
     * lista las inducciones especificas de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $induccion = $this->induccionRepository->listarConEmpleado($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $induccion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'err' => $th->getMessage(),
                'mensaje' => 'Error al listar las inducciones',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una induccion específica para un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearInduccionEspecificaRequest $request):JsonResponse{
        try {
            $induccion = $this->induccionRepository->crear($request->validated());
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
    public function actualizar(ActualizarInduccionEspecificaRequest $request, InduccionEspecifica $id){
        try {
            $this->induccionRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * contadoresInducciones - cuenta el total de inducciiones específicas según su estado
     *
     * @return void
     */
    public function contadoresInducciones()
    {
        $induccionesActivas = InduccionEspecifica::where('activo', 1)->count();
        $induccionesCerradas = InduccionEspecifica::where('activo', 0)->count();
        return response()->json([
            $induccionesActivas,
            $induccionesCerradas,
        ], Response::HTTP_OK);
    }

    /**
     * cerrar -  autoriza un induccion sobre un empleado
     *
     * @param  mixed $induccion
     * @return void
     */
    public function cerrar(InduccionEspecifica $induccion){
        try {
            $induccion->cerrar();
            return response()->json($induccion, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }
}
