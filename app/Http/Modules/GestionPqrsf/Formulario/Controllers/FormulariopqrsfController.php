<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Controllers;

use App\Http\Modules\GestionPqrsf\Formulario\Requests\ActualizarDatosContactoPqrsfRequest;
use Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Services\FormularioPqrsfService;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\CrearFormulariopqrsfRequest;
use App\Http\Modules\GestionPqrsf\Formulario\Repositories\FormulariopqrsfRepository;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\ActualizarFormulariopqrsfRequest;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\CargueMasivoSupersaludRequest;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\CrearPqrsfAutogestionRequest;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\EmailPqrRequest;
use App\Http\Modules\GestionPqrsf\Formulario\Requests\EncuestaSatisfaccionRequest;
use Exception;
use Illuminate\Support\Facades\Storage;

class FormulariopqrsfController extends Controller
{
    private $formularioPqrsfRepository;

    public function __construct(private FormularioPqrsfService $formularioPqrsfService)
    {
        $this->formularioPqrsfRepository = new FormulariopqrsfRepository;
    }

    /**
     * lista un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarPendientesInterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesInternaPqrsf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarPendientesCentral(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesCentralPqrf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarPresolucionCentral(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPresolucionCentralPqrf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista los PQRSF Solucionados
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @author Thomas
     */
    public function listarSolucionadosCentral(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadosCentral($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarAsignadosCentral(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadosCentralPqrf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista un formulario detalle pendiente de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarPendientesInternaDetalle(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesDetallePqrsf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista un formulario detalle pendiente de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarPendientesExternaDetalle(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesDetallePqrsf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista un formulario detalle pendiente de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listarAsignadosInternaDetalle(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadosDetallePqrsf($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Guarda un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearFormulariopqrsfRequest $request): JsonResponse
    {
        try {
            $formulario = $this->formularioPqrsfService->crear($request->validated());
            return response()->json($formulario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->actualizar($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta un formulario de PQRSF
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function consultar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfRepository->consultarPqr($request->all());
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function cambiarEstado(Request $request, Formulariopqrsf $id): JsonResponse
    {
        try {
            $nuevoEstado = $request->input('estado_id');
            $motivo = $request->input('motivo');

            $estadosValidos = [6, 10, 17];
            if (!in_array($nuevoEstado, $estadosValidos)) {
                return response()->json(['res' => false, 'mensaje' => 'Estado no válido.'], Response::HTTP_BAD_REQUEST);
            }

            $id->estado_id = $nuevoEstado;
            $id->save();

            $gestionPqrsfs = GestionPqrsf::where('formulario_pqrsf_id', $id->id)->first();
            if ($gestionPqrsfs) {
                $gestionPqrsfs->motivo = $motivo;
                $gestionPqrsfs->save();
            }

            return response()->json(['res' => true, 'mensaje' => 'Estado cambiado exitosamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['res' => false, 'mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historial($numeroCedula): JsonResponse
    {
        try {
            $idUsuario = auth()->user()->id;

            $afiliado = $this->formularioPqrsfRepository->obtenerAfiliadoPorCedula($numeroCedula);

            if ($afiliado) {
                $afiliado_id = $afiliado->id;

                $pqrsfCount = $this->formularioPqrsfRepository->verificarExistenciaPqrsf($afiliado_id, $numeroCedula);

                if ($pqrsfCount > 0) {
                    $historialPqrsf = $this->formularioPqrsfRepository->obtenerHistorialPqrsf($afiliado_id, $numeroCedula);

                    return response()->json(['res' => true, 'data' => $historialPqrsf], Response::HTTP_OK);
                } else {
                    return response()->json(['res' => false, 'mensaje' => 'No se encontraron PQRSF para el usuario.'], Response::HTTP_NOT_FOUND);
                }
            } else {
                return response()->json(['res' => false, 'mensaje' => 'No se encontró ningún afiliado con la cédula proporcionada.'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['res' => false, 'mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadoresPqrsfInterna()
    {
        try {
            $pqr = $this->formularioPqrsfRepository->contadoresPqrsfInterna();
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($pqr, Response::HTTP_OK);
    }

    public function contadoresPqrsfAdministracion()
    {
        try {
            $pqr = $this->formularioPqrsfRepository->contadoresPqrsfAdmin();
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($pqr, Response::HTTP_OK);
    }

    public function anular(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->anular($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function solucionar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->solucionar($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function asignar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->asignar($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarAsignados(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfRepository->listarPqrsfAsignados($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las PQRF asignadas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Responder PQRSF
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function respuesta(Request $request)
    {
        try {
            // Llama al servicio y obtiene el mensaje junto con los datos
            $pqr = $this->formularioPqrsfService->respuesta($request);

            // Retorna la respuesta con el mensaje y los datos
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            // En caso de error, devolver un mensaje de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error', 'error' => $th->getMessage()], 400);
        }
    }

    public function listarPresolucion(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPresolucion($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reclasificar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->reclasificar($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function respuestaFinal(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->respuestaFinal($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function reasignar(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->reasignar($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarSolucionados(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionados($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPendientesExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignadosExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadosExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPresolucionExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPresolucionExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSolucionadosExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadosExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignadosTodos(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfRepository->listarAsignadosTodos($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarSolucionadosTodos(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadosTodos($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cargueMasivo(Request $request): JsonResponse
    {
        try {
            $formulario = $this->formularioPqrsfService->cargueMasivo($request);
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reporte(Request $request)
    {
        // return $request->all();
        try {
            $aprobacion = $this->formularioPqrsfRepository->reporte($request);
            return $aprobacion;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function contadoresPqrsfExterna(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfRepository->contadoresPqrsfExterna($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($pqr, Response::HTTP_OK);
    }

    public function contadoresPqrsfTodos(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfRepository->contadoresPqrsfTodos($request);
            return response()->json($pqr, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($pqr, Response::HTTP_OK);
    }

    public function descargaFormato(Request $request)
    {
        try {
            $pqr = $this->formularioPqrsfService->descargaFormato();
            return $pqr;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crearPqrsfAutogestion(CrearPqrsfAutogestionRequest $request): JsonResponse
    {
        try {
            $formulario = $this->formularioPqrsfService->crearPqrsfAutogestion($request->validated());
            return response()->json($formulario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPqrsfAutogestion(): JsonResponse
    {
        try {
            $radicadoId = request()->input('radicado_id');
            $pqrs = $this->formularioPqrsfService->listarPqrsfAutogestion($radicadoId);

            return response()->json($pqrs, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarDatosContactoPqrsf($pqrsfId, ActualizarDatosContactoPqrsfRequest $request): JsonResponse
    {
        try {
            // Llama al servicio para actualizar los datos de contacto
            $response = $this->formularioPqrsfService->actualizarDatosContactoPqrsf($pqrsfId, $request->validated());

            // Devuelve la respuesta del servicio con un código de estado 200 (HTTP_OK)
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Devuelve el mensaje de error con un código de estado 400 (HTTP_BAD_REQUEST)
            return response()->json([
                'message' => 'Error al actualizar los datos de contacto.',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs pendientes de Gestion Externa (Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarPendientesGestionExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesGestionExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * lista las PQRFs asignadas de Gestion Externa (Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarAsignadasGestionExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadasGestionExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * lista las PQRFs presolucionadas de Gestion Externa (Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarPreSolucionadasGestionExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPreSolucionadasGestionExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * lista las PQRFs solucionadas de Gestion Externa (Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarSolucionadasGestionExterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadasGestionExterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs pendientes de Gestion Interna (Todos menos Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarPendientesGestionInterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPendientesGestionInterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs asignadas de Gestion Interna (Todos menos Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarAsignadasGestionInterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadasGestionInterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs presolucionadas de Gestion Interna (Todos menos Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarPreSolucionadasGestionInterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarPreSolucionadasGestionInterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs solucionadas de Gestion Interna (Todos menos Web y SuperSalud)
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarSolucionadasGestionInterna(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadasGestionInterna($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs asignadas a las áreas del usuario loggeado
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarAsignadasGestionArea(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarAsignadasGestionArea($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las PQRFs solucionadas asignadas a las áreas del usuario loggeado
     * @param Request $request
     * @return Response
     * @author Thomas
     */
    public function listarSolucionadasGestionArea(Request $request): JsonResponse
    {
        $formulario = $this->formularioPqrsfRepository->listarSolucionadasGestionArea($request);
        try {
            return response()->json($formulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de solicitud de PQRSF',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Creacion Masiva de PQRFs de Supersalud
     * @param CargueMasivoSupersaludRequest $request Recibe el formato del archivo de Excel
     * @return JsonResponse
     * @throws Exception
     * @author Thomas
     */
    public function cargueMasivoSupersalud(CargueMasivoSupersaludRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->formularioPqrsfService->cargueMasivoSupersalud($request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Creación de gestión para envíos de correo electronico al solucionar PQR
     * @param \App\Http\Modules\GestionPqrsf\Formulario\Requests\EmailPqrRequest $request
     * @return JsonResponse|mixed
     */
    public function solucionPqr(EmailPqrRequest $request)
    {
        try {
            #se recibe la respuesta
            $this->formularioPqrsfService->solucionEmailWebHook($request->validated());
            return response()->json(['success' => true], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Storage::append('Error_notificacion_pqr.txt', 'Error generado durante el registro del correo enviado en base de datos. -Error: ' . $th->getMessage());
        }
    }


    /**
     * Procesamiento y almacenamiento de la respuesta a la encuesta de satisfacción por parte del usuario
     * @param \App\Http\Modules\GestionPqrsf\Formulario\Requests\EncuestaSatisfaccionRequest $request
     * @return JsonResponse|mixed
     */
    public function encuestaSatisfaccion(EncuestaSatisfaccionRequest $request)
    {
        try{
            $respuesta = $this->formularioPqrsfService->guardarEncuesta($request->validated());
            return response()->json('ok', Response::HTTP_OK);
        }catch(\Throwable $th){
            return response()->json([
                'mensaje'=>'Hubo un error durante el registro de la respuesta de la encuesta',
                'error'=>$th->getMessage()
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
