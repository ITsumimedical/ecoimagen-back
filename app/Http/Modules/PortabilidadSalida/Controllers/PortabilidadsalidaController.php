<?php

namespace App\Http\Modules\PortabilidadSalida\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\PortabilidadSalida\Models\portabilidadSalida;
use App\Http\Modules\PortabilidadSalida\Requests\CrearPortabilidadSalidaRequest;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Http\Modules\PortabilidadSalida\Repositories\PortabilidadSalidaRepository;
use App\Http\Modules\PortabilidadSalida\Requests\ActualizarPortabilidadSalidaRequest;
use App\Http\Modules\PortabilidadSalida\Services\PortabilidadSalidaService;

class PortabilidadsalidaController extends Controller
{


    public function __construct(
        private NovedadAfiliadoRepository $novedadAfiliadoRepository,
        private PortabilidadSalidaRepository $portabilidadSalidarepository,
        private PortabilidadSalidaService $portabilidadSalidaService
    ) {
    }


    public function listar(Request $request)
    {
        try {
            $portabilidadSalida = $this->portabilidadSalidarepository->ListarPortabilidadSalida($request);
            return response()->json([
                'res' => true,
                'data' => $portabilidadSalida,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las portabilidades de salida',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarNovedades($afiliado_id, $portabilidad_salida_id)
    {
        try {
            $salida = $this->portabilidadSalidarepository->ListarNovedadesPorAfiliado($afiliado_id,  $portabilidad_salida_id);
            return response()->json($salida, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las portabilidades de salida',
            ], Response::HTTP_BAD_REQUEST);
        }
    }



    public function crear(CrearPortabilidadSalidaRequest $request)
    {
        try {
            $portabilidadSalida = $this->portabilidadSalidarepository->crearNuevaPortabilidadSalida($request->validated());
            $guardarAdjunto = $this->portabilidadSalidaService->guardarAdjunto($request, $portabilidadSalida->id);
            $novedad_afiliados = $this->novedadAfiliadoRepository->crearNovedadSalida($request, $portabilidadSalida->id);

            return response()->json([
                'res' => true,
                'data' => $novedad_afiliados,
                'mensaje' => 'Se ha creado con exito la portabilidad de salida!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una portabilidad de salida!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /** Actualizar Portabiilidad de salida
     * actualizar
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(ActualizarPortabilidadSalidaRequest $request, $id)
    {
        try {
            $userId = $request->user()->id;
            $afiliadoId = $request->input('afiliado_id');
            $portabilidadActualizada = $this->portabilidadSalidarepository->actualizarPortabilidad($id, $request->validated(), $userId, $afiliadoId);
            return response()->json(['mensaje' => 'Se ha actualizado la portabilidad de salida correctamente.', $portabilidadActualizada], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar la portabilidad de salida' => $th->getMessage()], 400);
        }
    }
    public function inactivar($id)
    {
        try {
            $this->portabilidadSalidarepository->InactivarPortabilidad($id);
            return response()->json(['mensaje' => 'Se ha inactivado la portabilidad de salida correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al inactivar la portabilidad de salida' => $th->getMessage()], 400);
        }
    }

    public function historial($numeroCedula): JsonResponse
    {
        try {
            $afiliado = $this->portabilidadSalidarepository->obtenerAfiliadoPorCedula($numeroCedula);

            if ($afiliado) {
                $afiliado_id = $afiliado->id;
                $historialPortabilidad = $this->portabilidadSalidarepository->obtenerHistorialPortabilidad($afiliado_id, $numeroCedula);

                return response()->json(['res' => true, 'data' => $historialPortabilidad], Response::HTTP_OK);
            } else {
                return response()->json(['res' => false, 'mensaje' => 'No se encontró ningún afiliado con la cédula proporcionada.'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['res' => false, 'mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verificarPortabilidadesActivas(Request $request)
    {
        try {
            $afiliado_id = $request->afiliado_id;
            $portabilidadesActivas = $this->portabilidadSalidarepository->verificarPortabilidadesActivas($afiliado_id);

            return response()->json(['res' => true, 'portabilidades_activas' => $portabilidadesActivas], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['res' => false, 'mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
