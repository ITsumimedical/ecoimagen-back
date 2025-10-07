<?php

namespace App\Http\Modules\NovedadesAfiliados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\NovedadesAfiliados\Requests\CrearNovedadAfiliadoRequest;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Http\Modules\NovedadesAfiliados\Requests\ActualizarNovedadAfiliadoRequest;
use App\Http\Modules\NovedadesAfiliados\Services\NovedadAfiliadosService;

class NovedadAfiliadoController extends Controller
{
    private $novedadAfiliadorepository;
    private $novedadAfiliadosService;
    private $service;

    public function __construct(
        NovedadAfiliadoRepository $novedadAfiliadorepository,
        NovedadAfiliadosService $novedadAfiliadosService
    ) {
        $this->novedadAfiliadorepository = $novedadAfiliadorepository;
        $this->novedadAfiliadosService = $novedadAfiliadosService;
    }

    /**
     * lista las novedades del afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        $paginar = $request['page'] ?? 5;
        $novedadAfiliado = $this->novedadAfiliadorepository->listar($paginar);
        try {
            return response()->json([
                'res' => true,
                'data' => $novedadAfiliado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las novedades del afiliado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una novedad del afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(int $afiliado_id, CrearNovedadAfiliadoRequest $request): JsonResponse
    {
        try {
            $novedad = $this->novedadAfiliadosService->crearNovedad($afiliado_id, $request->validated());

            return response()->json([
                'res' => true,
                'data' => $novedad,
                'mensaje' => '¡Se ha creado la novedad con éxito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear una novedad.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una novedad de un afiliado
     * @param Request $request
     * @param int id
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarNovedadAfiliadoRequest $request, int $id): Jsonresponse
    {
        try {
            $novedadAfiliado = $this->novedadAfiliadorepository->buscar($id);
            $novedadAfiliado->fill($request->all());
            $actualizarNovedadAfiliado = $this->novedadAfiliadorepository->guardar($novedadAfiliado);
            return response()->json([
                'res' => true,
                'data' => $actualizarNovedadAfiliado,
                'mensaje' => 'La novedad fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar la novedad!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * buscar una novedad de un afiliado
     * @param Request $request
     * @param int id
     * @return Response
     * @author kobatime
     */
    public function novedadAfiliado(int $afiliado_id, Request $request)
    {
        try {
            $novedadAfiliado = $this->novedadAfiliadorepository->buscarNovedadAfiliado($afiliado_id, $request);
            return response()->json($novedadAfiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar buscar las novedades!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Busca una novedad por id
     * @param mixed $novedadId
     * @return JsonResponse|mixed
     */
    public function buscarNovedadPorId($novedadId)
    {
        try {
            $novedad = $this->novedadAfiliadorepository->buscarNovedadPorId($novedadId);
            return response()->json($novedad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar buscar las novedades!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
