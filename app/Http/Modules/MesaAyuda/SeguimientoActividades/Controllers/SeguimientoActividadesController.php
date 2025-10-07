<?php

namespace App\Http\Modules\MesaAyuda\SeguimientoActividades\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Repositories\SeguimientoActividadesRepository;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Requests\ActualizarSeguimientoActividadesRequest;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Requests\CrearSeguimientoActividadesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeguimientoActividadesController extends Controller
{
    private $seguimientoActividadesRepository;

    public function __construct(SeguimientoActividadesRepository $seguimientoActividadesRepository)
    {
        $this->seguimientoActividadesRepository = $seguimientoActividadesRepository;
    }

    /**
     * funcion para listar
     *
     * @param  mixed $request
     *
     * @return JsonResponse
     * @author Camilo luna
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $seguimientoActividades = $this->seguimientoActividadesRepository->listar($request);
            return response()->json($seguimientoActividades, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No fue posible listar el seguimiento de las actividades'
            ]);
        }
    }

    /**
     * funcion para crear un seguimiento de la mesa de ayuda
     *
     * @param $request
     *
     * @return JsonResponse
     *
     * @author Camilo
     */
    public function crear(CrearSeguimientoActividadesRequest $request): JsonResponse
    {
        try {
            $this->seguimientoActividadesRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Seguimiento de la actividad creada con éxito'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear el seguimiento de la actividad'
            ]);
        }
    }

    /**
     * funcion para actualizar la respuesta a la mesa de ayuda
     *
     * @param $request
     *
     * @param mixed $id
     * @return JsonResponse
     *
     * @author Camilo
     */
    public function actualizar(ActualizarSeguimientoActividadesRequest $request, int $id): JsonResponse
    {
        try {
            $seguimientoActividades = $this->seguimientoActividadesRepository->buscar($id);
            $seguimientoActividades->fill($request->validated());
            $this->seguimientoActividadesRepository->guardar($seguimientoActividades);
            return response()->json([
                'mensaje' => '¡Se ha actualizado correctamente la respuesta a la mesa de ayuda!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => '¡Error al actualizar la respuesta!'
            ]);
        }
    }
}

