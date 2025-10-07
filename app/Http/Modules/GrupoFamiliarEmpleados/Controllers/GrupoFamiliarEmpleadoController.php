<?php

namespace App\Http\Modules\GrupoFamiliarEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\GrupoFamiliarEmpleados\Models\GrupoFamiliarEmpleado;
use App\Http\Modules\GrupoFamiliarEmpleados\Requests\CrearGrupoFamiliarEmpleadoRequest;
use App\Http\Modules\GrupoFamiliarEmpleados\Repositories\GrupoFamiliarEmpleadoRepository;
use App\Http\Modules\GrupoFamiliarEmpleados\Requests\ActualizarGrupoFamiliarEmpleadoRequest;

class GrupoFamiliarEmpleadoController extends Controller
{
    private $grupoFamiliarRepository;

    public function __construct(){
        $this->grupoFamiliarRepository = new GrupoFamiliarEmpleadoRepository;
    }

    /**
     * lista los grupos familiares
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $grupoFamiliar = $this->grupoFamiliarRepository->listarGrupoFamiliarEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $grupoFamiliar
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los grupos familiares del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un grupo familiar sobre un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearGrupoFamiliarEmpleadoRequest $request):JsonResponse{
        try {
            $grupoFamiliar = $this->grupoFamiliarRepository->crear($request->validated());
            return response()->json($grupoFamiliar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Actualiza un grupo familiar de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarGrupoFamiliarEmpleadoRequest $request, GrupoFamiliarEmpleado $id){
        try {
            $this->grupoFamiliarRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
