<?php

namespace App\Http\Modules\TipoServicioTutelas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoServicioTutelas\Models\TipoServicioTutela;
use App\Http\Modules\TipoServicioTutelas\Repositories\TipoServicioRepository;
use App\Http\Modules\TipoServicioTutelas\Requests\ActualizarTipoServicioTutelaRequest;
use App\Http\Modules\TipoServicioTutelas\Requests\GuardarTipoServicioTutelaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipoServicioTutelaController extends Controller
{
    private $tipoServicioRepository;

    function __construct(){
        $this->tipoServicioRepository = new TipoServicioRepository();
    }

    /**
     * listar los tipos de servicio
     * @param Request $request
     * @return Response $tipoServicio
     * @author Arles Garcia
     */


    public function listar(Request $request)
    {
        try {
            $tipoServicio = $this->tipoServicioRepository->listar($request);
            return response()->json($tipoServicio);
        } catch (\Throwable $th) {
            return response()->json(
              $th->getMessage()
            , 400);
        }
    }

    /**
     * Almacena un tipo de servicio
     * @param Request $request
     * @return Response $tipoServicio
     * @author Arles Garcia
     */

    public function guardar(GuardarTipoServicioTutelaRequest $request): JsonResponse{
        try {
            $tipoServicio = $this->tipoServicioRepository->crear($request->validated());
            return response()->json($tipoServicio, 201);
        } catch (\Throwable $th) {
             return response()->json(
                 $th->getMessage()
                , 400);
        }
    }

     /**
     * actualiza un tipo de servicio
     * @param Request $request
     * @return Response $tipoServicio
     * @author Arles Garcia
     */

    public function actualizar(ActualizarTipoServicioTutelaRequest $request,TipoServicioTutela $servicio): JsonResponse{
        try {
            $tipoServicio = $this->tipoServicioRepository->guardar($servicio,$request->validated());
            return response()->json($tipoServicio, 200);
        } catch (\Throwable $th) {
             return response()->json(
                $th->getMessage()
            , 400);
        }
    }
}
