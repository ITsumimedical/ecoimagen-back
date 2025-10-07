<?php

namespace App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Repositories\EvaluacionesDesempenoRepository;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Requests\CreateEvaluacionesDesempenoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Formats\CertificadoEvaluacionDesempeno;

class EvaluacionesDesempenoController extends Controller
{
    protected $evaluacionDesempeñoRepository;

    public function __construct(EvaluacionesDesempenoRepository $evaluacionDesempeñoRepository) {
        $this->evaluacionDesempeñoRepository = $evaluacionDesempeñoRepository;
    }

    /**
     * Consultar si un empleado tiene una evaluacion en curso o crearla
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function consultaSiTieneEvaluacionOcrearleUna(CreateEvaluacionesDesempenoRequest $request)
    {
        try {
            $listar = $this->evaluacionDesempeñoRepository->firstOrCreateEvaluacionDesempeno($request);
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    //Pendiente funcion para actualizar la evaluacion desempeno a estado 0 que es terminada

    public function plantillas(Request $request)
    {
        try {
            $plantilla = $this->evaluacionDesempeñoRepository->listar($request);
            return response()->json($plantilla, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function miPlantilla(int $plantilla_id)
    {
        try {
            $plantilla = $this->evaluacionDesempeñoRepository->PlantillaEvaluacion($plantilla_id);
            return response()->json($plantilla, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function finalizarEvaluacion(Request $request,$id)
    {
        try {
            $data = $this->evaluacionDesempeñoRepository->finalizarEvaluacion($id,$request);
            return response()->json(['data' =>$data,'mensaje' => 'evaluacion finalizada con exito'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function printfpdf($id)
    {
        $pdf = new CertificadoEvaluacionDesempeno();
        $pdf->generate($id);
    }

}
