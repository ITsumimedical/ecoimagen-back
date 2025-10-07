<?php

namespace App\Http\Modules\ConsentimientosInformados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ConsentimientosInformados\Repositories\ConsentimientosInformadosRepository;
use App\Http\Modules\ConsentimientosInformados\Requests\ActualizarConsentimientoRequest;
use App\Http\Modules\ConsentimientosInformados\Requests\CrearConsentimientoRequest;
use App\Http\Modules\ConsentimientosInformados\Requests\GuardarFiramaRequest;
use App\Http\Modules\ConsentimientosInformados\Services\ConsentimientosInformadosService;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Illuminate\Support\Facades\Log;

class ConsentimientosInformadosController extends Controller
{
    public function __construct(protected ConsentimientosInformadosRepository $consentimientosInformadosRepository, protected ConsentimientosInformadosService $consentimientosInformadosService) {}

    /**
     * listar
     *
     * @param  string $request
     * @return JsonResponse
     * @author jdss
     */

    public function listar()
    {
        try {
            $consentimientos = $this->consentimientosInformadosService->listar();
            return response()->json($consentimientos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los consentimientos informados',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearConsentimientoRequest $request): JsonResponse
    {
        try {
            $consentimiento = $this->consentimientosInformadosService->crearConsentimiento($request->validated());
            return response()->json([
                $consentimiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un consentimiento
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarConsentimientoRequest $request)
    {
        try {
            $actualizarRol = $this->consentimientosInformadosService->actualizar($request->all());
           
            return response()->json([$actualizarRol], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'mensaje' => 'Error al actualizar el consentimiento informado',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }


    /**
     * consulta un consentimiento
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function consultar(Request $request)
    {
        try {
            $consentimiento = $this->consentimientosInformadosRepository->consultarConsentimiento($request->all());
            return response()->json($consentimiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                ['mensaje' => 'Error al consultar'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Consulta consentimientos informados asociados a un arreglo de ID's de procedimientos que llega
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     * @author AlejoSR
     */
    public function consultarGrupo(Request $request)
    {
        try {
            $consentimientos = $this->consentimientosInformadosService->consultarConsentimientosGrupo($request->all());
            return response()->json($consentimientos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                ['mensaje' => 'Error al consultar','error'=>$th->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Cambio de estado
     */
    public function cambiarEstadoFormulario($codigo)
    {
        try {
            $estado = $this->consentimientosInformadosRepository->actualizarEstadoConsentimiento($codigo);
            return response()->json($estado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    // public function cambiarEstadoLaboratorio(Request $request){
    //     try{
    //         $laboratorio = $this->consentimientosInformadosService->actualizarEstadoLaboratorio($request->all());
    //         return response()->json($laboratorio, Response::HTTP_OK);

    //     } catch(\Throwable $th){
    //         return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function listarConsentimientos(Request $request)
    {
        try {
            $consentimiento = $this->consentimientosInformadosRepository->listarConsentimientosHistorico($request);
            return response()->json($consentimiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarFirma(GuardarFiramaRequest $request, int $id)
    {
        try {
            $firma = $this->consentimientosInformadosRepository->guardarFirma($id, $request->all());
            return response()->json($firma, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consulta los Cups asociados al consentimiento informado
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function consultarCupConsentimiento(Request $request)
    {
        try{
            $cups = $this->consentimientosInformadosService->consultarCupFormato($request->all());
            return response()->json($cups,Response::HTTP_OK);

        }catch(\Throwable $th){
            return response()->json(
                [
                    'mensaje' => 'Error consultando los cups asociados al consentimiento',
                    'error' => $th->getMessage()
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Elimina cup del consentimiento informado
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function eliminarCup(int $id, Request $request)
    {
        try{
            $respuesta = $this->consentimientosInformadosService->eliminarCup($id);
            return response()->json($respuesta,Response::HTTP_OK);
        }catch(\Throwable $th){
            return response()->json(
                [
                    'mensaje' => 'Error eliminando el cup',
                    'error' => $th->getMessage()
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

}
