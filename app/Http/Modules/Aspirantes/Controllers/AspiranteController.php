<?php

namespace App\Http\Modules\Aspirantes\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Aspirantes\Models\Aspirante;
use App\Http\Modules\Aspirantes\Repositories\AspiranteRepository;
use App\Http\Modules\Aspirantes\Requests\ActualizarAspiranteRequest;
use App\Http\Modules\Aspirantes\Requests\CrearAspiranteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AspiranteController extends Controller
{
    private $aspiranteRepository;

    public function __construct(AspiranteRepository $aspiranteRepository) {
        $this->aspiranteRepository = $aspiranteRepository;
    }

    /**
     * listar aspirantes
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function listar(Request $request)
    {
        try {
            $page = $request['page'] ?? 5;
            $aspirantes = $this->aspiranteRepository->listar($page);
            return response()->json([
                'res' => true,
                'data' => $aspirantes
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar aspirantes',
                'err' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un aspirante
     * @param Request $request->all()
     * @return Response
     * @author Calvarez
     */
    public function crear(CrearAspiranteRequest $request): JsonResponse
    {
        try {
            $aspirante = new Aspirante($request->all());
            $nuevoAspirante = $this->aspiranteRepository->guardar($aspirante);
            return response()->json([
                'res' => true,
                'data' => $nuevoAspirante,
                'mensaje' => 'Aspirante creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear aspirante!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un aspirante
     * @param Request $request
     * @param int id
     * @return Response
     * @author Calvarez
     */
    public function actualizar(ActualizarAspiranteRequest $request, int $id): JsonResponse
    {
        try {
            $aspirante = $this->aspiranteRepository->buscar($id);
            $aspirante->fill($request->all());
            $this->aspiranteRepository->guardar($aspirante);
            return response()->json([
                'mensaje' => 'El aspirante fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar actualizar el aspirante!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
