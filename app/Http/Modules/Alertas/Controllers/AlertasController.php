<?php

namespace App\Http\Modules\Alertas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Alertas\Repositories\AlertasRepository;
use App\Http\Modules\Alertas\Request\CrearMedicamentoAlertaRequest;
use App\Http\Modules\Alertas\Request\CrearPrincipalAlertaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlertasController extends Controller
{
    public function __construct(
        private AlertasRepository $alertasRepository,
    ) {}

    /**
     * Funcion para crear una alerta de medicamentos
     *
     * @param  mixed $request
     * @return void
     */
    public function crearAlertaMedicamento(CrearMedicamentoAlertaRequest $request)
    {
        try {
            $this->alertasRepository->crearAlertaMedicamento($request->validated());
            return response()->json([
                'mensaje' => 'Alerta de medicamento creada con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Funcion para crear una alerta a los principios activos
     *
     * @param  mixed $request
     * @return void
     */
    public function crearAlertaPrincipal(CrearPrincipalAlertaRequest $request)
    {
        try {
            $this->alertasRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Alerta de principal creada con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Funcion para listar las alertas a los principios activos
     *
     * @param  mixed $request
     * @return void
     */
    public function listarAlertasPrincipales(Request $request)
    {
        try {
            $principales = $this->alertasRepository->listarPrincipal($request);
            return response()->json($principales);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Funcion para listar las alertas de los medicamentos/codesumis
     *
     * @return void
     */
    public function listarCodesumis(Request $request)
    {
        try {
            $medicamentos = $this->alertasRepository->listarCodesumi($request);
            return response()->json([$medicamentos]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $data = $request->all();
            $alertaActualizada = $this->alertasRepository->actualizar($id, $data);
            return response()->json([
                'mensaje' => 'actualizado con éxito',
                'alerta' => $alertaActualizada
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado(Request $request, $id)
    {
        try {
            $alerta = $this->alertasRepository->cambiarEstado($id);
            return response()->json(['message' => 'Estado de la alerta cambiado exitosamente', $alerta], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscarAlergico(Request $request)
    {
        try {
            $alergico = $this->alertasRepository->validarAlergia($request->afiliado_id, $request->codesumi_id,);
            return response()->json($alergico, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function buscarDesabastecimiento(Request $request)
    {
        try {
            $desabastecimiento = $this->alertasRepository->desabastecimiento($request);
            return response()->json($desabastecimiento);
        } catch (\Throwable $th) {
            return response()->json(
                'error al buscar el desabastecimientos de los medicamentos',
                $th->getMessage()
            );
        }
    }

    // public function buscarAlertas(Request $request)
    // {
    //     try {
    //         $resultado = $this->alertasRepository->buscarAlertas($request);
    //       return $resultado;
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage()], 400);
    //     }
    // }


    public function verificarInteraccion(Request $request)
    {
        try {

            // Obtener los medicamentos seleccionados
            $medicamentosSeleccionados = $request->input('medicamentosSeleccionados');

            // Llamar al método del repositorio para verificar interacciones entre los medicamentos seleccionados
            $interacciones = $this->alertasRepository->verificarInteraccionEntreMedicamentos($medicamentosSeleccionados);

            if ($interacciones) {
                // Retornar las interacciones encontradas
                return response()->json([ $interacciones], Response::HTTP_OK);
            } else {
                // Si no hay interacciones, retornamos un mensaje de que no se encontraron alertas
                return response()->json(['message' => 'No se encontraron interacciones entre los medicamentos seleccionados.'], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function crearAuditoria(Request $request)
    {
        try {
            $auditoria = $this->alertasRepository->crearAuditoria($request);
            return response()->json($auditoria, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarAuditoria(Request $request)
    {
        try {
            $auditoria = $this->alertasRepository->listarAuditoriaAlertas($request->all());
            return response()->json($auditoria, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al cargar las Alertas'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
