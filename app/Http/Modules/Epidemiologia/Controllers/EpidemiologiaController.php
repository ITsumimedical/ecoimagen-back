<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\EpidemiologiaRepository;
use App\Http\Modules\Epidemiologia\Requests\ActualizarRespuestaRequest;
use App\Http\Modules\Epidemiologia\Requests\DevolverFichaMedicoRequest;
use App\Http\Modules\Epidemiologia\Requests\GuardarRespuestaRequest;
use App\Http\Modules\Epidemiologia\Services\EpidemiologiaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EpidemiologiaController extends Controller
{

    public function __construct(private readonly EpidemiologiaService $epidemiologiaService, private readonly EpidemiologiaRepository $epidemiologiaRepository) {}

    /**
     * Lista las cabeceraras y los campos que le pertenecen
     * @param int $id
     * @return JsonResponse
     * @author Sofia O
     */
    public function listarCabeceraCampos(int $id): JsonResponse
    {
        try {
            $cabecerasCampos = $this->epidemiologiaRepository->listarCabeceraConCampos($id);
            return response()->json($cabecerasCampos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los campos y cabeceras'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda las respuestas de la ficha epidemiologica
     * @param GuardarRespuestaRequest $request
     * @return JsonResponse
     * @author Sofia O
     */
    public function guardarRespuestas(GuardarRespuestaRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->epidemiologiaService->guardarRespuesta($request->validated());
            return response()->json($respuesta, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al guardar las respuestas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista por rep del ususrio los diagnosticos registrados
     * @param Request $request
     * @return JsonResponse
     * @author Sofia O
     */
    public function listarConsultasDiagnosticoEpidemiologia(Request $request): JsonResponse
    {
        try {
            $consultaDiagnostico = $this->epidemiologiaRepository->listarConsultaDiagnosticoEpidemiologia($request->all());
            return response()->json($consultaDiagnostico, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los diagnosticos de las fichas epidemiologicas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista todos los diagnosticos registrados
     * @param Request $request
     * @return JsonResponse
     * @author Sofia O
     */
    public function listarTodasConsultasDiagnosticoEpidemiologia(Request $request): JsonResponse
    {
        try {
            $consultaDiagnostico = $this->epidemiologiaRepository->listarTodasConsultaDiagnosticoEpidemiologia($request->all());
            return response()->json($consultaDiagnostico, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los diagnosticos de las fichas epidemiologicas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambia el estado del formulario a revisado
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @author Sofia O
     */
    public function cambiarEstadoFormulario(Request $request, int $id): JsonResponse
    {
        try {
            $estadoFormulario = $this->epidemiologiaRepository->actualizarEstadoFormulario($request->all(), $id);
            return response()->json($estadoFormulario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al cambiar el estado del formulario'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para descargar los pdfs de la ficha epidemiologica
     * @param Request $request
     * @return Response|JsonResponse
     * @author Sofia O
     */
    public function descargarPdfEpidemiologiaSivigila(Request $request): Response|JsonResponse
    {
        try {
            $pdf = $this->epidemiologiaService->generarFichaNotificacion($request->id);
            return response($pdf, Response::HTTP_OK)
                ->header('Content-Type', 'application/pdf');
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las ips que ya tengan registros creados
     * @param Request $request
     * @return JsonResponse
     * @author Sofia O
     */
    // public function listarIps(Request $request): JsonResponse
    // {
    //     try {
    //         $ips = $this->epidemiologiaRepository->listarIps($request->all());
    //         return response()->json($ips, Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'mensaje' => 'Hubo un error al listar las ips'
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    /**
     * Actualiza las respuestas de la ficha epidemiologica
     * @param ActualizarRespuestaRequest $request
     * @return JsonResponse
     * @author Sofia O
     */
    public function actualizarRespuestas(ActualizarRespuestaRequest $request): JsonResponse
    {
        try {
            $actualizarRespuesta = $this->epidemiologiaService->actualizarRespuesta($request->validated());
            return response()->json($actualizarRespuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al actualizar las respuestas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerRespuestas(Request $request): JsonResponse
    {
        try {
            $respuestas = $this->epidemiologiaRepository->obtenerRespuestas($request->all());
            return response()->json($respuestas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al obtener las respuestas del formulario'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para cambiar el estado y devolver la ficha epidemiologica
     * @param DevolverFichaMedicoRequest $request
     * @param int $id
     * @return JsonResponse
     * @author Sofia O
     */
    public function devolverFichaMedico(DevolverFichaMedicoRequest $request, int $id): JsonResponse
    {
        try {
            $devolver = $this->epidemiologiaRepository->devolverFichaMedico($request->validated(), $id);
            return response()->json($devolver, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al devolver la ficha al medico responsable'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para listar las observacion de cada registro cuando se devuelven
     * @param int $id
     * @return JsonResponse
     * @author Sofia O
     */
    public function listarObservacionesDevolucion(int $id): JsonResponse
    {
        try {
            $observaciones = $this->epidemiologiaRepository->listarObservacionesDevolucion($id);
            return response()->json($observaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar las observaciones de los motivos de devolucion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
