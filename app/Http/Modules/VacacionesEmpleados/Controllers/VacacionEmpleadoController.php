<?php

namespace App\Http\Modules\VacacionesEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\VacacionesEmpleados\Models\VacacionEmpleado;
use App\Http\Modules\VacacionesEmpleados\Requests\CrearVacacionEmpleadoRequest;
use App\Http\Modules\VacacionesEmpleados\Repositories\VacacionEmpleadoRepository;
use App\Http\Modules\VacacionesEmpleados\Requests\ActualizarVacacionEmpleadoRequest;

class VacacionEmpleadoController extends Controller
{
    private $vacacionEmpleadoRepository;

    public function __construct(){
        $this->vacacionEmpleadoRepository = new VacacionEmpleadoRepository;
    }

    /**
     * lista las vacaciones registradas a un empleado segun el id de su contrato
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        $vacacionEmpleado = $this->vacacionEmpleadoRepository->listarVacacionContrato($request, $id);
        try {
            return response()->json([
                'res' => true,
                'data' => $vacacionEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las vacaciones del contrato',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una vacacion sobre un contrato de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearVacacionEmpleadoRequest $request):JsonResponse{
        try {
            $vacacion = $this->vacacionEmpleadoRepository->crear($request->validated());
            return response()->json($vacacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una vacación de un empleado según el id de su contrato
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarVacacionEmpleadoRequest $request, VacacionEmpleado $id){
        try {
            $this->vacacionEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }


    /**
     * autorizar -  autoriza una vacación de un empleado sobre su contrato activo
     *
     * @param  mixed $vacacion
     * @return void
     */
    public function autorizar(VacacionEmpleado $vacacion){
        try {
            $vacacion->autorizar();
            return response()->json($vacacion, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * anular - anula una vacación sobre un contrato de un empleado
     *
     * @param  mixed $vacacion
     * @return void
     */
    public function anular(VacacionEmpleado $vacacion){
        try {
            $vacacion->anular();
            return response()->json($vacacion, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }
}
