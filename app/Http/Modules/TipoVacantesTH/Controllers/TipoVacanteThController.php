<?php

namespace App\Http\Modules\TipoVacantesTH\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoVacantesTH\Models\TipoVacanteTh;
use App\Http\Modules\TipoVacantesTH\Repositories\TipoVacanteRepository;
use App\Http\Modules\TipoVacantesTH\Requests\ActualizarTipoVacanteThRequest;
use App\Http\Modules\TipoVacantesTH\Requests\CrearTipoVacanteThRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoVacanteThController extends Controller
{
    private $tipoVacanteRepository;

    public function __construct(TipoVacanteRepository $tipoVacanteRepository) {
        $this->tipoVacanteRepository = $tipoVacanteRepository;
    }

    /**
     * lista los tipos de vacantes
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function listar(Request $request)
    {
        try {
            $paginar = $request['page'] ?? 5;
            $tipoVacates = $this->tipoVacanteRepository->listar($paginar);
            return response()->json([
                'res' => true,
                'data' => $tipoVacates
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar tipo de vacantes!.',
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de vacante
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function crear(CrearTipoVacanteThRequest $request): JsonResponse
    {
        try {
            $nuevoTipoVacante = new TipoVacanteTh($request->all());
            $tipoVacate = $this->tipoVacanteRepository->guardar($nuevoTipoVacante);
            return response()->json([
                'res' => true,
                'data' => $tipoVacate,
                'mensaje' => '',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de vacante
     * @param Request $request
     * @param $id int
     * @return Response
     * @author Calvarez
     */
    public function actualizar(ActualizarTipoVacanteThRequest $request, int $id)
    {
        try {
            $tipoVacante = $this->tipoVacanteRepository->buscar($id);
            $tipoVacante->fill($request->all());
            $actualizarTipoVacante = $this->tipoVacanteRepository->guardar($tipoVacante);
            return response()->json([
                'res' => true,
                'data' => $actualizarTipoVacante,
                'mensaje' => 'El tipo de vacante fue actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el tipo de vacante!.',
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
