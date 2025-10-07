<?php

namespace App\Http\Modules\PortabilidadEntrada\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Http\Modules\PortabilidadEntrada\Repositories\PortabilidadEntradaRepository;
use App\Http\Modules\PortabilidadEntrada\Requests\ActualizarPortabilidadEntradaRequest;
use App\Http\Modules\PortabilidadEntrada\Requests\CrearPortabilidadEntradaRequest;
use App\Http\Modules\PortabilidadEntrada\Services\PortabilidadEntradaService;
use App\Http\Modules\Usuarios\Services\UsuarioService;
use Illuminate\Http\Request;

class PortabilidadEntradaController extends Controller
{

    public function __construct(
        private NovedadAfiliadoRepository $novedadAfiliadoRepository,
        private PortabilidadEntradaRepository $portabilidadEntradarepository,
        private PortabilidadEntradaService $portabilidadEntradaservice
    ) {
    }

    /**
     * lista las portabilidades de entrada
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listarPortabilidad(Request $request)
    {
        try {
            $portabilidadEntrada = $this->portabilidadEntradarepository->listarPortabilidadEntrada($request);
            return response()->json($portabilidadEntrada, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las portabilidades de entrada',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una portabilidad de entrada
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearPortabilidadEntradaRequest $request)
    {
        try {
            $portabilidadEntrada = $this->portabilidadEntradarepository->crearNuevaPortabilidadEntrada($request->validated());
            $guardarAdjunto = $this->portabilidadEntradaservice->guardarAdjunto($request, $portabilidadEntrada->id);
            $novedad_afiliados = $this->novedadAfiliadoRepository->crearNovedadEntrada($request->validated(), $portabilidadEntrada->id);

            return response()->json([
                'res' => true,
                'data' => $novedad_afiliados,
                'mensaje' => 'Se ha creado con exito la portabilidad de entrada!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear una portabilidad de entrada!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inactivar($id)
    {
        try {
            $this->portabilidadEntradarepository->InactivarPortabilidadEntrada($id);
            return response()->json(['mensaje' => 'Se ha inactivado la portabilidad de entrada correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al inactivar la portabilidad de entrada' => $th->getMessage()], 400);
        }
    }

    public function actualizar(ActualizarPortabilidadEntradaRequest $request, $id)
    {
        try {
            $userId = $request->user()->id;
            $afiliadoId = $request->input('afiliado_id');
            $portabilidadActualizada = $this->portabilidadEntradarepository->actualizarPortabilidadEntrada($id, $request->validated(), $userId, $afiliadoId);
            return response()->json(['mensaje' => 'Se ha actualizado la portabilidad de entrada correctamente.', $portabilidadActualizada], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar la portabilidad de entrada' => $th->getMessage()], 400);
        }
    }

    public function listarNovedadesEntrada($afiliado_id, $portabilidad_entrada_id)
    {
        try {
            $salida = $this->portabilidadEntradarepository->portabilidadEntradaNovedades($afiliado_id, $portabilidad_entrada_id);
            return response()->json($salida, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las portabilidades de salida',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historial($numeroCedula): JsonResponse
    {
        try {
            $afiliado = $this->portabilidadEntradarepository->obtenerAfiliadoPorCedula($numeroCedula);

            if ($afiliado) {
                $afiliado_id = $afiliado->id;
                $historialPortabilidad = $this->portabilidadEntradarepository->obtenerHistorialPortabilidad($afiliado_id, $numeroCedula);

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
            $portabilidadesActivas = $this->portabilidadEntradarepository->verificarPortabilidadesActivas($afiliado_id);

            return response()->json(['res' => true, 'portabilidades_activas' => $portabilidadesActivas], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['res' => false, 'mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
