<?php

namespace App\Http\Modules\Oncologia\Organos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Oncologia\Organos\Models\Organo;
use App\Http\Modules\Oncologia\Organos\Repositories\OrganoRepository;
use App\Http\Modules\Oncologia\Organos\Requests\CrearOrganoRequest;


class OrganoController extends Controller
{
    private $organoRepository;

    public function __construct(OrganoRepository $organoRepository) {
        $this->organoRepository = $organoRepository;
    }

    /**
     * listar - Lista los órganos
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(Request $request)
    {
        try {
            $organos = $this->organoRepository->listar($request);
            return response()->json($organos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los organos!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crear - Crea un órgano
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function crear(CrearOrganoRequest $request):JsonResponse{
        try {
            $organo = $this->organoRepository->crear($request->validated());
            return response()->json($organo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear un órgano'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar - Actualiza un órgano según el id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(CrearOrganoRequest $request, Organo $id){
        try {
            $this->organoRepository->actualizar($id, $request->validated());
            return response()->json([
                'mensaje' => 'órgano actualizado con éxito!.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al actualizar el órgano'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
