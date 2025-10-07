<?php

namespace App\Http\Modules\Cac\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Cac\Repositories\PatologiasCacRepository;
use App\Http\Modules\Cac\Requests\CrearPatologiacCacRequest;
use App\Http\Modules\Cac\Requests\GenerarArchivoCacRequest;
use App\Http\Modules\Cac\Requests\GestionarEspecialidadesPatologiaRequest;
use App\Http\Modules\Cac\Services\CacService;
use App\Jobs\GenerarArchivoCac;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CacController extends Controller
{
    public function __construct(
        private readonly PatologiasCacRepository $patologiasCacRepository,
        private readonly CacService $cacService
    ) {
    }

    /**
     * Crea una patologia de CAC
     * @param CrearPatologiacCacRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function crearPatologia(CrearPatologiacCacRequest $request): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->crear($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista todas las patologias de CAC
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarPatologias(Request $request): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->listarPatologias($request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Activa o inactiva una patologia
     * @param int $patologia_id
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function cambiarEstado(int $patologia_id): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->cambiarEstado($patologia_id);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Asocia especialidades a una patologia
     * @param GestionarEspecialidadesPatologiaRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function asociarEspecialidadesPatologia(GestionarEspecialidadesPatologiaRequest $request): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->asociarEspecialidadesPatologia($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remueve especialidades de una patologia
     * @param GestionarEspecialidadesPatologiaRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function removerEspecialidadesPatologia(GestionarEspecialidadesPatologiaRequest $request): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->removerEspecialidadesPatologia($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar especialidades de una patologia
     * @param int $patologia_id
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarEspecialidadesPatologia(int $patologia_id): JsonResponse
    {
        try {
            $response = $this->patologiasCacRepository->listarEspecialidadesPatologia($patologia_id);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Genera el archivo CAC
     * @param GenerarArchivoCacRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function generarArchivoCac(GenerarArchivoCacRequest $request): JsonResponse
    {
        try {
            GenerarArchivoCac::dispatch($request->validated())->onQueue('cac');

            return response()->json([
                'mensaje' => 'Se ha iniciado el proceso de generar el archivo CAC'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}