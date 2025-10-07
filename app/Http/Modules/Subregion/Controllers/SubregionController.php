<?php

namespace App\Http\Modules\Subregion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Subregion\Repositories\SubregionRepository;
use App\Http\Modules\Subregion\Requests\GuardarSubregionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SubregionController extends Controller
{
    protected $Repository;

    function __construct(){
        $this->Repository = new SubregionRepository();
    }

    /**
     * listar subregiones
     * @param Request $request
     * @return Response $medicos
     * @author kobatime
     */

    public function listarSubregion(Request $request)
    {
        try {
            $subregion = $this->Repository->listar($request);
            return response()->json($subregion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al mostrar los datos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Almacena una subregion
     * @param Request $request
     * @return Response $juzgado
     * @author kobatime
     */

    public function guardar(GuardarSubregionRequest $request): JsonResponse{
        try {
            // se envia los datos al repositorio
            $subregion = $this->Repository->crear($request->all());
            return response()->json([
                'res' => true,
                $subregion,
                'mensaje' => 'Se agrego correctamente!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar agregar!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un juzgado
     * @param Request $request
     * @return Response $juzgado
     * @author kobatime
     */

    public function actualizar(GuardarSubregionRequest $request,int $id): JsonResponse{
        try {
             // se busca el juzgado
            $subregion = $this->Repository->buscar($id);
            // se realiza una comparacion de los datos
            $subregion->fill($request->all());
            // se envia los datos al repositorio
            $actualizar_subregion = $this->Repository->guardar($subregion);
            return response()->json([
                'res' => true,
                $actualizar_subregion,
                'mensaje' => 'Fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
