<?php

namespace App\Http\Modules\ParametrizacionPlanCuidados\Controllers;

//use App\Http\Modules\Paises\Repositories\PaisRepository;
use App\Http\Modules\ParametrizacionPlanCuidados\Repositories\ParametrizacionPlanCuidadoRepository;
use App\Http\Modules\ParametrizacionPlanCuidados\Services\ParametrizacionPlanCuidadoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class ParametrizacionPlanCuidadoController extends Controller
{
    public function __construct(
        protected ParametrizacionPlanCuidadoService $parametrizacionPlanCuidadoService,
        protected ParametrizacionPlanCuidadoRepository $parametrizacionPlanCuidadoRepository
    ){}
    public function crear($id,request $request)
    {
        try {
            $planCuidado = $this->parametrizacionPlanCuidadoService->crear($id,$request->all());
            return response()->json($planCuidado, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el plan de cuidado',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(){
//        try {
            $planesCuidados = $this->parametrizacionPlanCuidadoRepository->listarPlanes();
            return response()->json($planesCuidados, Response::HTTP_OK);
//        } catch (\Throwable $th) {
//            return response()->json([
//                'res' => false,
//                'mensaje' => 'Error al recuperar los planes de cuidado',
//            ], Response::HTTP_BAD_REQUEST);
//        }
    }
}
