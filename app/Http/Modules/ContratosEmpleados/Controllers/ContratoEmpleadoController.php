<?php

namespace App\Http\Modules\ContratosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\ContratosEmpleados\Requests\CrearContratoEmpleadoRequest;
use App\Http\Modules\ContratosEmpleados\Repositories\ContratoEmpleadoRepository;
use App\Http\Modules\ContratosEmpleados\Requests\ActualizarContratoEmpleadoRequest;
use App\Http\Modules\ContratosEmpleados\Requests\TerminarContratoEmpleadoRequest;
use App\Http\Modules\ContratosEmpleados\Services\ContratoEmpleadoService;

class ContratoEmpleadoController extends Controller
{
    private $contratoEmpleadoRepository;
    private $contratoEmpleadoService;

    public function __construct(ContratoEmpleadoRepository $contratoEmpleadoRepository, ContratoEmpleadoService $contratoEmpleadoService){
       $this->contratoEmpleadoRepository = $contratoEmpleadoRepository;
       $this->contratoEmpleadoService = $contratoEmpleadoService;
    }

    /**
     * lista los contratos de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $contratoEmpleado = $this->contratoEmpleadoRepository->listarContratoEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $contratoEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los contratos del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un contrato de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearContratoEmpleadoRequest $request){
        try {
            $empleado_contrato_nuevo = $request->empleado_id;
            $contratos_empleado = ContratoEmpleado::select('empleado_id', $empleado_contrato_nuevo)->where('empleado_id', $request->empleado_id)->where('activo',1)->count();
            if ($contratos_empleado > 0) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El empleado ya cuenta con un contrato vigente'
                ], Response::HTTP_BAD_REQUEST);
            }else {
                $contrato = $this->contratoEmpleadoRepository->crear($request->validated());
                return response()->json($contrato,201);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * Actualiza un contrato empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarContratoEmpleadoRequest $request, int $id): JsonResponse
    {
        try {
            $contratoEmpleado = $this->contratoEmpleadoRepository->buscar($id);
            $contratoEmpleado->fill($request->all());

            $actualizaContratoEmpleado = $this->contratoEmpleadoRepository->guardar($contratoEmpleado);

            return response()->json([
                'res' => true,
                'data' => $actualizaContratoEmpleado,
                'mensaje' => 'Contrato actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el contrato'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function terminar(TerminarContratoEmpleadoRequest $request, int $id): JsonResponse
    {
        try {
            $contratoEmpleado = $this->contratoEmpleadoRepository->buscar($id);
            $contratoEmpleado->fill($request->validated());

            $terminaContratoEmpleado = $this->contratoEmpleadoService->terminar($contratoEmpleado,$request->validated());

            return response()->json([
                'res' => true,
                'data' => $terminaContratoEmpleado,
                'mensaje' => 'Contrato terminado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al terminar el contrato'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cierreMes(Request $request)
    {
        try {
            $contratoEmpleado = $this->contratoEmpleadoRepository->contratosPorFechaIngreso($request);
            $cerrarMes = $this->contratoEmpleadoService->cierreMes($contratoEmpleado,$request->fecha_cierre_mes);
            return response()->json($cerrarMes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los contratos laborales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
