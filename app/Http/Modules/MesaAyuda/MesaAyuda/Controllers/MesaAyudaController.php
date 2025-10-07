<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\MesaAyuda\MesaAyuda\Services\MesaAyudaService;
use App\Http\Modules\MesaAyuda\MesaAyuda\Requests\crearMesaAyudaRequest;
use App\Http\Modules\MesaAyuda\MesaAyuda\Repositories\MesaAyudaRepository;
use App\Http\Modules\MesaAyuda\MesaAyuda\Requests\DefinirFechaMetaRequest;
use App\Http\Modules\MesaAyuda\MesaAyuda\Requests\actualizarMesaAyudaRequest;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Repositories\AdjuntosMesaAyudasRepository;
use App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Repositories\AsignadosMesaAyudaRepository;

use App\Http\Modules\MesaAyuda\MesaAyuda\Services\MesaAyudaFomagService;
use App\Http\Modules\MesaAyuda\MesaAyuda\Services\MesaAyudaMedicinaIntegralService;
use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use PhpParser\Node\Stmt\TryCatch;

class MesaAyudaController extends Controller
{
    protected $fomagService;
    protected $medicinaintegralservice;
    private $mesaAyudaRepository;
    private $adjuntosMesaAyudasRepository;
    private $mesaAyudaService;
    protected $fomagHttp;

    public function __construct(
        MesaAyudaRepository $mesaAyudaRepository,
        AdjuntosMesaAyudasRepository $adjuntosMesaAyudasRepository,
        MesaAyudaService $mesaAyudaService,
        private AsignadosMesaAyudaRepository $asignadosMesaAyudaRepository,
        MesaAyudaFomagService $fomagService,
        FomagHttp  $fomagHttp
    ) {
        $this->mesaAyudaRepository = $mesaAyudaRepository;
        $this->adjuntosMesaAyudasRepository = $adjuntosMesaAyudasRepository;
        $this->mesaAyudaService = $mesaAyudaService;
        $this->fomagService = $fomagService;
        $this->fomagHttp = $fomagHttp;
    }

    /**
     * funcion para listar la mesa de ayuda
     *
     * @param  mixed $request
     * @return JsonResponse
     *
     * @author Camilo
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $mesaAyuda = $this->mesaAyudaRepository->listarTodos($request);
            return response()->json($mesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarMisSolicitudes(Request $request)
    {
        try {
            $solicitudes = $this->mesaAyudaRepository->listarMisCasos($request);
            return response()->json($solicitudes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * funcion para listar casos pendientes por area
     *
     * @param  mixed $request
     * @return JsonResponse
     *
     * @author Calvarez
     */
    public function contadorCasosPendientes(Request $request) //: JsonResponse
    {
        try {
            $contadorCasosPendientesHorus = $this->mesaAyudaRepository->contadorCasosPendientesHorus();
            $contadorCasosPendientesFPS = $this->mesaAyudaRepository->contadorCasosPendientesFPS();
            $contadorCasosPendientesNORTE = $this->mesaAyudaRepository->contadorCasosPendientesNORTE();
            return response()->json([
                'horus' => $contadorCasosPendientesHorus,
                'fps' => $contadorCasosPendientesFPS,
                'norte' => $contadorCasosPendientesNORTE,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * funcion crear una mesa de ayuda
     *
     * @param  mixed $request
     * @return JsonResponse
     *
     * @author calvarez
     */
    public function crearCaso(crearMesaAyudaRequest $request)
    {
        try {
            $nuevoCaso = $this->mesaAyudaService->radicar($request->validated());
            return response()->json([
                $nuevoCaso,
                'Mensaje' => 'Mesa de ayuda creada correctamente'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * funcion para actualizar una mesa de ayuda segun el id
     *
     * @param  mixed $request
     *
     * @param  mixed $id
     * @return JsonResponse
     *
     * @author Camilo
     */
    public function actualizar(actualizarMesaAyudaRequest $request, int $id): JsonResponse
    {
        try {
            $mesaAyuda = $this->mesaAyudaRepository->buscar($id);
            $mesaAyuda->fill($request->validated());
            $this->mesaAyudaRepository->guardar($mesaAyuda);
            return response()->json([
                'mensaje' => 'El caso fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar el caso!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSolicitudesHorus(Request $request)
    {

        try {
            $solicitudesArea = $this->mesaAyudaRepository->listarCasosPendientesArea($request);
            return response()->json($solicitudesArea, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'error al consultar solicitudes del area'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorMisPendientes(Request $request)
    {
        try {
            $solicitudesIndividuales = $this->mesaAyudaRepository->contadorMisPendientes();
            return response()->json($solicitudesIndividuales, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar solicitudes del area'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorSolucionados(Request $request)
    {
        try {
            $solicitudesSolucionadas = $this->mesaAyudaRepository->contadorSolucionados();
            return response()->json($solicitudesSolucionadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar solicitudes del area'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * obtener los adjuntos de la solicitud
     *
     * @param  mixed $request
     * @return void
     */
    public function consultarAdjuntos(Request $request)
    {
        try {
            $adjuntosSolicitudMesaAyuda = $this->mesaAyudaRepository->consultarAdjuntos($request);
            return response()->json($adjuntosSolicitudMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los adjuntos'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

    // public function reasignarSolicitud(Request $request)
    // {
    //     try {
    //         $reasignarSolicitud = $this->mesaAyudaRepository->reasignarSolicitud($request);
    //         return response()->json($reasignarSolicitud, Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'mensaje' => 'error al reasignar la solicitud'
    //         ],  Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function reasignarCaso(Request $request, $id)
    {
        try {
            $casoReasignado = $this->mesaAyudaService->reasignar($id, $request);
            return response()->json([
                'Mensaje' => 'Mesa de ayuda reasignada correctamente',
                'Caso' => $casoReasignado
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function solucionarSolicitud(Request $request, int $mesaAyudaId): JsonResponse
    {
        try {
            $this->mesaAyudaService->solucionarSolicitud($request, $mesaAyudaId);

            return response()->json([
                'message' => 'Solicitud solucionada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function anularSolicitud(Request $request, int $mesaAyudaId): JsonResponse
    {
        try {
            $this->mesaAyudaRepository->anularSolicitud($request, $mesaAyudaId);

            return response()->json([
                'message' => 'Solicitud anulada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function asignar(Request $request): JsonResponse
    {

        try {
            $this->mesaAyudaRepository->actualizarEstadoAsignado($request);
            $this->mesaAyudaRepository->asignar($request);

            return response()->json([
                'message' => 'Solicitud anulada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignados(Request $request): JsonResponse
    {
        try {
            $mesaAyuda = $this->mesaAyudaRepository->listarAsignados($request);
            return response()->json($mesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function devolver(Request $request)
    {
        try {
            $this->mesaAyudaRepository->actualizarEstadoPendiente($request->id);
            $this->asignadosMesaAyudaRepository->quitarRegistro($request->id);
            $this->mesaAyudaRepository->crearSeguimiento($request->id, Auth::user()->id, $request->respuesta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reabrirCaso(Request $request, $id)
    {
        try {
            $casoReabierto = $this->mesaAyudaService->reabrirCaso($id, $request);
            return response()->json([
                'mensaje' => 'Caso reabierto exitosamente',
                'data' => $casoReabierto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al reabrir el caso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function Comentario(Request $request, $id)
    {
        try {
            $casoReabierto = $this->mesaAyudaService->comentario($id, $request);
            return response()->json([
                'mensaje' => 'Comentario enviado exitosamente',
                'data' => $casoReabierto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error con el caso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function gestionando(Request $request, $id)
    {
        try {
            $casoReabierto = $this->mesaAyudaService->gestionando($id, $request);
            return response()->json([
                'mensaje' => 'gestionando el caso exitosamente',
                'data' => $casoReabierto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error con el caso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function listarSolucionados(Request $request): JsonResponse
    {
        try {
            $mesaAyuda = $this->mesaAyudaRepository->listarSolucionados($request);
            return response()->json($mesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los casos de creados!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function calificarGestion(Request $request, $mesaAyudaId)
    {
        $calificacion = $request->input('calificacion');
        $this->mesaAyudaService->calificarGestion($mesaAyudaId, $calificacion);

        return response()->json(['message' => 'Calificación guardada exitosamente.']);
    }


    public function ResponderComentario(Request $request, $id)
    {
        try {
            $responderComentario = $this->mesaAyudaService->responderComentario($id, $request);
            return response()->json([
                'mensaje' => 'Respuesta al caso enviada con éxito',
                $responderComentario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al enviar la respuesta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function definirFechaMeta(DefinirFechaMetaRequest $request, int $id): JsonResponse
    {
        try {
            $this->mesaAyudaService->definirFechaMeta(
                $id,
                $request->fecha_meta_solucion,
                $request->input('motivo')
            );

            return response()->json(['message' => 'Fecha meta definida correctamente.']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al definir la fecha.'], 500);
        }
    }

    public function consultarMesaPorId(int $id): JsonResponse
    {
        try {
            $consultar = $this->mesaAyudaRepository->buscarMesaPorId($id);
            return response()->json($consultar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las mesas de ayuda!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarAdjuntosConUrl(Request $request)
    {
        try {
            $adjuntosConUrl = $this->mesaAyudaRepository->consultarAdjuntosConUrl($request);
            return response()->json($adjuntosConUrl, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los adjuntos con URL'
            ],  Response::HTTP_BAD_REQUEST);
        }
    }
}
