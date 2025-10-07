<?php

namespace App\Http\Modules\CuentasMedicas\Glosas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\Glosas\Requests\CrearGlosaRequest;
use App\Http\Modules\CuentasMedicas\Glosas\Repositories\GlosaRepository;

class GlosaController extends Controller
{
    private $glosaRepository;

    public function __construct(GlosaRepository $glosaRepository) {
        $this->glosaRepository = $glosaRepository;
    }

     /**
     * lista las facturas glosadas
     * @return Response $facturas
     * @author JDSS
     */
    public function listaFacturaGlosa(Request $request,int $af_id){
        try {
            $facturas = $this->glosaRepository->listarFacturasGlosa($request,$af_id);
            return response()->json($facturas,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crea o actualiza una glosa
     * @return Response $facturas
     * @author JDSS
     */
    public function glosa(CrearGlosaRequest $request): JsonResponse
    {
        try {
            $facturas = $this->glosaRepository->glosar($request->all());
            return response()->json($facturas,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al crear',
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las facturas a glosar de un prestador
     * @return Response $glosaPrestador
     * @author JDSS
     */
    public function facturasGlosarPrestador(Request $request, int $af_id){
        try {
            $glosaPrestador = $this->glosaRepository->glosasPrestador($request, $af_id);
            return response()->json($glosaPrestador,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al crear',
            ],  Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las glosas para conciliacion
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function glosasConciliacion(Request $request,int $id_af){
        try {
         $afConciliacion = $this->glosaRepository->glosasConciliacion($request ,$id_af);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listas las glosas cerradas
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function glosasCerrada(Request $request,int $id_af){
        try {
         $afConciliacion = $this->glosaRepository->glosasCerradas($request ,$id_af);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listas las glosas de las facturas para la auditoria final
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function facturaGlosaAuditoriaFinal(Request $request,int $id_af){
        try {
         $afConciliacion = $this->glosaRepository->glosasFacturaFinal($request ,$id_af);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las glosas de las facturas para la auditoria final
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function facturaConciliada(Request $request,int $id_af){
        try {
         $afConciliacion = $this->glosaRepository->facturasGlosasConciliadas($request ,$id_af);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las glosas de las facturas para la auditoria final que tengan saldo a conciliar
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function facturaConciliadaConSaldo(Request $request,int $id_af){
        try {
         $afConciliacion = $this->glosaRepository->facturasGlosasConciliadasConSaldo($request ,$id_af);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }


}
