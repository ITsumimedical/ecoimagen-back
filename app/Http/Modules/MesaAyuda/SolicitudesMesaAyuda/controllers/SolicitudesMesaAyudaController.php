<?php

namespace App\Http\Modules\MesaAyuda\SolicitudesMesaAyuda\controllers;

use App\Http\Controllers\Controller;
use App\http\Modules\MesaAyuda\SolicitudesMesaAyuda\Repositories\SolicitudesMesaAyudaRepository;
use App\Http\Modules\MesaAyuda\SolicitudesMesaAyuda\Requests\CrearSolicitudesMesaAyudaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SolicitudesMesaAyudaController extends Controller
{

    private $solicitudesMesaAyudaRepository;

    public function __construct(SolicitudesMesaAyudaRepository $solicitudesMesaAyudaRepository)
    {
        $this->solicitudesMesaAyudaRepository = $solicitudesMesaAyudaRepository;
    }


    /**
     * funcion para guardar las solicitudes de la parametrizacion
     *
     * @param  mixed $request
     * @return JsonResponse
     *
     * @author Camilo
     */
    public function guardarParametrizacionSolicitud(CrearSolicitudesMesaAyudaRequest $request): JsonResponse
    {
        try {
            $nuevaSolicitud = $this->solicitudesMesaAyudaRepository->crear($request->validated());
            return response()->json([
                $nuevaSolicitud,
                'mensaje' => 'Solicitud de parametrización creada correctamente'
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json([
                'Error al crear la solicitud de parametrización'
            ]);
        }
    }

    public function listarSolicitudes()
    {
        try {
            $solicitudesMesaAyuda = $this->solicitudesMesaAyudaRepository->listarSolicitudes();
            return response()->json($solicitudesMesaAyuda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar parametrización mesa ayuda',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
