<?php

namespace App\Http\Modules\PqrsfTipoCanales\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\PqrsfCanales\Repositories\PqrsfCanalRepository;
use App\Http\Modules\PqrsfCanales\Requests\ActualizarPqrsfTipoCanalRequest;
use App\Http\Modules\PqrsfCanales\Requests\CrearPqrsfCanalRequest;
use App\Http\Modules\PqrsfCanales\Services\PqrsfTipoCanalService;

class PqrsfTipoCanalController extends Controller
{
    protected $tipoCanalRepository;
    protected $tipoCanalService;

    public function __construct() {
        $this->tipoCanalRepository = new PqrsfCanalRepository();
        $this->tipoCanalService = new PqrsfTipoCanalService();
    }


    /**
     * lista de tipo canales
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {

            $TipoCanal = $this->tipoCanalRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $TipoCanal
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los tipos de canal',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de canal pqrsf
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearPqrsfCanalRequest $request): JsonResponse
    {
        try {
            // se usa servicio para añadir el usuario quien crear el tipo de canal
            $TipoSolcitud = $this->tipoCanalService->prepararData($request->validated());
            //se envia la data a repository
            $nuevoTipoSolcitud = $this->tipoCanalRepository->crear($TipoSolcitud);
            return response()->json([
                'res' => true,
                'data' => $nuevoTipoSolcitud,
                'mensaje' => 'Se creo el tipo de canal con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el tipo de canal!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza estado del tipo de solicitud
     * @param Request $request
     * @param int $id
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarPqrsfTipoCanalRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de solicitud
            $TipoSolcitud = $this->tipoCanalRepository->buscar($id);
            // se realiza una comparacion de los datos
            $TipoSolcitud->fill($request->all());
            // se envia los datos al repositorio
            $actualizarTipoSolcitud = $this->tipoCanalRepository->guardar($TipoSolcitud);
            return response()->json([
                'res' => true,
                'data' => $actualizarTipoSolcitud,
                'mensaje' => 'El tipo de solicitud fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el tipo de solicitud!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
