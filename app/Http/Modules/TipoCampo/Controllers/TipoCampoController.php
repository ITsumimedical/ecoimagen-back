<?php

namespace App\Http\Modules\TipoCampo\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoCampo\Models\TipoCampo;
use App\Http\Modules\TipoCampo\Repositories\TipoCampoRepository;
use App\Http\Modules\TipoCampo\Requests\ActualizarTipoCampoRequest;
use App\Http\Modules\TipoCampo\Requests\CrearTipoCampoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoCampoController extends Controller
{
    private $tipoCampoRepository;


    public function __construct(){
        $this->tipoCampoRepository = new TipoCampoRepository;
    }

    /**
     * lista los tipos de campos
     * @param Request $request
     * @return Response $tipoCampo
     * @author JDSS
     */
    public function listar(Request $request)
    {
        try {
            $tipoCampo = $this->tipoCampoRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $tipoCampo
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipo de campos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de campo
     * @param Request $request
     * @return Response $tipoCampo
     * @author JDSS
     */
    public function crear(CrearTipoCampoRequest $request): JsonResponse
    {
        try {
            $nuevoTipoCampo = new TipoCampo($request->all());
            $tipoCampo = $this->tipoCampoRepository->guardar($nuevoTipoCampo);
            return response()->json([
                'res' => true,
                'data' => $tipoCampo,
                'mensaje' => 'Se creo el tipo de campo con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el tipo de campo!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de campo
     * @param Request $request
     * @param int $id
     * @return Response $actualizarTipoCampo
     * @author JDSS
     */
    public function actualizar(ActualizarTipoCampoRequest $request, int $id): JsonResponse
    {
        try {
            $tipoCampo = $this->tipoCampoRepository->buscar($id);
            $tipoCampo->fill($request->all());
            $actualizarTipoCampo = $this->tipoCampoRepository->guardar($tipoCampo);
            return response()->json([
                'res' => true,
                'data' => $actualizarTipoCampo,
                'mensaje' => 'El tipo de campo fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el tipo de campo!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
