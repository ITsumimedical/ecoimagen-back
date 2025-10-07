<?php

namespace App\Http\Modules\InformacionCuidador\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\InformacionCuidador\Models\InformacionCuidador;
use App\Http\Modules\InformacionCuidador\Repositories\InformacionCuidadorRepository;
use App\Http\Modules\InformacionCuidador\Requests\ActualizarInformacionCuidadorRequest;
use App\Http\Modules\InformacionCuidador\Requests\CrearInformacionCuidadorRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InformacionCuidadorController extends Controller
{

    private $informacionCuidadorRepository;

    public function __construct()
    {
        $this->informacionCuidadorRepository = new InformacionCuidadorRepository;
    }

    /**
     * Crear la informacion del cuidador
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function crearInformacionCuidador(CrearInformacionCuidadorRequest $request): JsonResponse
    {
        try {
            $cuidador = $this->informacionCuidadorRepository->crear($request->validated());
            return response()->json($cuidador, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar la información de los cuidadores
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function listarInformacionCuidadors(Request $request): JsonResponse
    {
        try {
            $cuidadors = $this->informacionCuidadorRepository->listar($request);
            return response()->json($cuidadors, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar la informacion de un cuidador
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * @author Manuela
     */
    public function actualizarInformacionCuidador(ActualizarInformacionCuidadorRequest $request, InformacionCuidador $id): JsonResponse
    {
        try {
            $cuidador = $this->informacionCuidadorRepository->actualizar($id, $request->validated());
            return response()->json([
                'res' => true,
                'data' => $cuidador,
                'mensaje' => 'La información del cuidador fue actualizada con éxito.'
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

}
