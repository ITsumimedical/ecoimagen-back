<?php

namespace App\Http\Modules\InformacionResponsables\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\InformacionResponsables\Models\InformacionResponsable;
use App\Http\Modules\InformacionResponsables\Repositories\InformacionResponsableRepository;
use App\Http\Modules\InformacionResponsables\Requests\ActualizarInformacionResponsableRequest;
use App\Http\Modules\InformacionResponsables\Requests\CrearInformacionResponsableRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InformacionResponsableController extends Controller
{
    private $informacionResponsableRepository;

    public function __construct(InformacionResponsableRepository $informacionResponsableRepository)
    {
        $this->informacionResponsableRepository = $informacionResponsableRepository;
    }
    /**
     * crear la informacion de un responsable
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function crearInformacionResponsable(CrearInformacionResponsableRequest $request): JsonResponse
    {
        try {
            $responsable = $this->informacionResponsableRepository->crear($request->validated());
            return response()->json($responsable, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar la informacion de los esponsables
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function listarInformacionResponsables(Request $request): JsonResponse
    {
        try {
            $responsable = $this->informacionResponsableRepository->listar($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar la informacion de un responsable
     *
     * @param  mixed $request
     * @param  mixed $id -> modelo
     * @return JsonResponse
     * @author Manuela
     */
    public function actualizarInformacionResponsable(ActualizarInformacionResponsableRequest $request, InformacionResponsable $id): JsonResponse
    {
        try {
            $responsable = $this->informacionResponsableRepository->actualizar($id, $request->validated());
            return response()->json([
                'res' => true,
                'data' => $responsable,
                'mensaje' => 'La información del responsable fue actualizada con exito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

}
