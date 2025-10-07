<?php

namespace App\Http\Modules\ActuacionTutelas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ActuacionTutelas\Services\ActuacionTutelaService;
use App\Http\Modules\ActuacionTutelas\Repositories\ActuacionTutelaRepository;
use App\Http\Modules\ActuacionTutelas\Requests\GuardarActuacionTutelaRequest;

class ActuacionTutelaControllers extends Controller
{

    public function __construct(private ActuacionTutelaRepository $actuacionTutelaRepository,
                                private ActuacionTutelaService $actuacionTutelaService)
    {

    }

    public function listar(Request $request, $id) {
        try {
            $actuacion = $this->actuacionTutelaService->listarActuacion($request, $id);
            return response()->json($actuacion);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(GuardarActuacionTutelaRequest $request):JsonResponse{
        try {
            $actuacion = $this->actuacionTutelaService->crearActuacionTutela($request);
            return response()->json(['respuesta'=>$actuacion, 'mensaje'=>'La actuación fue creada con éxito'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function asignar(Request $request){
        try {
            $actuacion = $this->actuacionTutelaService->asignar($request);
            return response()->json(['respuesta'=>'OK', 'mensaje'=>'Se asignó la acción satisfactoriamente'],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignada(Request $request) {
        try {
            $actuacion = $this->actuacionTutelaService->listarAsignada($request);
            return response()->json($actuacion);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignadaCerrada(Request $request) {
        try {
            $actuacion = $this->actuacionTutelaService->listarAsignadaCerrada($request);
            return response()->json($actuacion);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAsignadaCerradaTemporal(Request $request) {
        try {
            $actuacion = $this->actuacionTutelaService->listarCerradaTemporal($request);
            if ($actuacion) {
                return response()->json(['res'=> $actuacion, 'mensaje'=>'Actuación listada correctamente'],Response::HTTP_OK);
            }

        }catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'mensaje'=>'Error al listar las actuaciones' ], Response::HTTP_BAD_REQUEST);
        }
    }
}
