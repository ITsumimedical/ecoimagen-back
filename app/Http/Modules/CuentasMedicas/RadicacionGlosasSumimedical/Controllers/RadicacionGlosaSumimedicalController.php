<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\ActasCuentasMedicas\Repositories\ActasCuentasMedicasRepository;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Repositories\RadicacionGlosasSumimedicalRepository;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Requests\CrearRadicacionGlosaSumimedicalRequest;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Requests\ValidacionExcelAdministrativoRequest;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Requests\ValidacionExcelRequest;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Services\RadicacionGlosaSumiService;

class RadicacionGlosaSumimedicalController extends Controller
{

    public function __construct(
        private RadicacionGlosasSumimedicalRepository $radicacionGlosasSumimedicalRepository,
        private RadicacionGlosaSumiService $radicacionGlosaSumiService,
        private ActasCuentasMedicasRepository $actasCuentasMedicasRepository)
        {
        }

    /**
     * Crea o actualiza una radicacion de una glosa de sumimedical
     * @return Response $radicacion
     * @author JDSS
     */
    public function crearActualizarRadicacionGlosa(CrearRadicacionGlosaSumimedicalRequest $request){
        try {
            $radicacion = $this->radicacionGlosasSumimedicalRepository->crearActualizar($request->validated());
            return response()->json($radicacion,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarAccionConciliacion(ValidacionExcelRequest $request){
        try {
            $excel = $this->radicacionGlosaSumiService->validacionExcel($request->validated());
            return response()->json($excel);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error'],Response::HTTP_BAD_REQUEST);
        }


    }

    public function guardarAccionConciliacionAdministrativa(ValidacionExcelAdministrativoRequest $request){
        try {
            $excel = $this->radicacionGlosaSumiService->validacionExcelAdministrativo($request->validated());
            return response()->json($excel);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error'],Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarAccionConciliacionConSaldo(ValidacionExcelRequest $request){
        try {
            $excel = $this->radicacionGlosaSumiService->validacionExcelConSaldo($request->validated());
            return response()->json($excel);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error'],Response::HTTP_BAD_REQUEST);
        }


    }

    public function actas(Request $request){
        try {
            $acta = $this->actasCuentasMedicasRepository->actas($request->all());
            return response()->json($acta,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error'],Response::HTTP_BAD_REQUEST);
        }
    }

    public function informe(Request $request){
        try {
            $evento = $this->radicacionGlosasSumimedicalRepository->informe($request->all());
            return $evento;
           } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ],Response::HTTP_BAD_REQUEST);
           }
    }


}
