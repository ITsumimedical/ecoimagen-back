<?php

namespace App\Http\Modules\Juzgados\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Juzgados\Repositories\JuzgadoRepository;
use App\Http\Modules\Juzgados\Requests\ActualizarJuzgadoRequest;
use App\Http\Modules\Juzgados\Requests\GuardarJuzgadoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class JuzgadoController extends Controller
{
    private $juzgadoRepository;

    function __construct(JuzgadoRepository $juzgadoRepository){
        $this->juzgadoRepository = $juzgadoRepository;
    }

    /**
     * listar los juzgados
     * @param Request $request
     * @return Response $juzgado
     * @author Manuela
     */

    public function listar(Request $request): JsonResponse
    {
        try {
            $juzgado = $this->juzgadoRepository->listarJuzgado($request);
            return response()->json($juzgado, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los juzgados'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea un juzgado
     * @param Request $request
     * @return Response $juzgado
     * @author Manuela
     */

    public function crear(GuardarJuzgadoRequest $request): JsonResponse
    {
        try {
            $this->juzgadoRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'El juzgado fue creado con exito!'
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar crear el juzgado!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un juzgado
     * @param Request $request
     * @return Response $juzgado
     * @author Manuela
     */

    public function actualizar(ActualizarJuzgadoRequest $request, int $id): JsonResponse
    {
        try {
             // se busca el juzgado
            $juzgado = $this->juzgadoRepository->buscar($id);
            // se realiza una comparacion de los datos y se validan
            $juzgado->fill($request->validated());
            // se envia los datos al repositorio
            $this->juzgadoRepository->guardar($juzgado);
            return response()->json([
                'mensaje' => 'El juzgado fue actualizado con exito!'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar actualizar el juzgado!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * buscar un juzgado específico
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function buscar(Request $request): JsonResponse
    {
        try {
            $buscar = $this->juzgadoRepository->consultarLike('nombre', $request->nombre);
            return response()->json([
                $buscar,
                'mensaje' => 'El juzgado fue consultado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al intentar consultar el juzgado!'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
