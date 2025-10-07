<?php

namespace App\Http\Modules\CuentasMedicas\Facturas\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\Facturas\Services\FacturaService;
use App\Http\Modules\CuentasMedicas\Glosas\Repositories\GlosaRepository;
use App\Http\Modules\CuentasMedicas\Insumos\Repositories\InsumoRepository;
use App\Http\Modules\CuentasMedicas\Facturas\Repositories\FacturaRepository;
use App\Http\Modules\CuentasMedicas\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\CuentasMedicas\Medicamentos\Repositories\MedicamentoRepository;
use App\Http\Modules\CuentasMedicas\Facturas\Requests\CrearAsignadoCuentanMecidaRequest;
use App\Http\Modules\CuentasMedicas\Facturas\Requests\GuardarServicioRequest;
use App\Http\Modules\CuentasMedicas\Procedimientos\Repositories\ProcedimientoRepository;

class FacturasController extends Controller
{


    public function __construct( private FacturaRepository $facturaRepository,
                                private FacturaService $facturaService,
                                private GlosaRepository $glosaRepository,
                                private ConsultaRepository $consultaRepository,
                                private ProcedimientoRepository $procedimientoRepository,
                                private InsumoRepository $insumoRepository,
                                private MedicamentoRepository $medicamentoRepository) {
    }

     /**
     * lista las facturas del prestador
     * @param Request $request
     * @return Response $factura
     * @author JDSS
     */
    public function listarFacturaPrestador(Request $request){
        try {
            $factura = $this->facturaRepository->listarFactura($request);
            return response()->json($factura,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function asignarFactura(CrearAsignadoCuentanMecidaRequest $request){
        try {
            $factura = $this->facturaService->facturasAsignadas($request->validated());
            return response()->json($factura,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorFacturas(){
        try {
            $contador = $this->facturaRepository->contador();
            return response()->json($contador,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarServicio(GuardarServicioRequest $request, int $id_Af){
        try {
            $guardarServicio = $this->facturaRepository->guardarServicio($request->validated(), $id_Af);
            return response()->json($guardarServicio,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las facturas asignadas
     * @return Response $facturas
     * @author JDSS
     */
    public function asignacionFactura(int $idPrestador){
        try {
            // se consulta la información en el repositorio
            $facturas = $this->facturaRepository->asignacionFactura($idPrestador);
            // con la informacion ya consultada se hace un proceso para calcular los dias habiles y retornar todo la información
            $calculo = $this->facturaService->calcularDiasHabiles($facturas);
            return response()->json($calculo,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guarda la auditoria
     * @return Response $facturas
     * @author JDSS
     */

     public function guardarAuditoria(int $id_af){
        try {
            $auditoria = $this->facturaRepository->guardarAuditoria($id_af);
            return response()->json($auditoria,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las facturas
     * @return Response $auditadas
     * @author JDSS
     */

     public function facturas(Request $request, int $prestador_id){
        try {
            $auditadas = $this->facturaRepository->facturas($request, $prestador_id);
            return response()->json($auditadas,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
     }

     /**
     * devuleve una factura al estado de asignada
     * @return Response $facturas
     * @author JDSS
     */

    public function devolverAuditoria(int $id_af){
        try {
            $auditoria = $this->facturaRepository->devolverAuditoria($id_af);
            return response()->json($auditoria,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las facturas de un prestador
     * @return Response $afPrestador
     * @author JDSS
     */
    public function facturasPrestador(Request $request){
        try {
         $afPrestador = $this->facturaRepository->facturaPrestador($request);
         return response()->json($afPrestador,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * actualiza la factura ya que se finalizo el proceso de auditoria, se actualiza el estado
     * @return Response $facturas
     * @author JDSS
     */

     public function guardarAuditoriaPrestador(int $id_af){
        try {
            $auditoria = $this->facturaRepository->guardarAuditoriaPrestador($id_af);
            return response()->json($auditoria,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * listas las facturas de un prestador
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function facturasConciliacion(Request $request){
        try {
         $afConciliacion = $this->facturaRepository->facturaConciliacion($request);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listas las facturas de un prestador que esten cerradas
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function facturasCerradas(Request $request){
        try {
         $afConciliacion = $this->facturaRepository->facturaCerrada($request);
         return response()->json($afConciliacion,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las facturas en auditoria final
     * @return Response $auditadas
     * @author JDSS
     */

     public function facturaAuditoriaFinal(Request $request){
        try {
            $auditadas = $this->facturaRepository->facturasAuditoriaFinal($request);
            return response()->json($auditadas,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
     }

     /**
     * listas las facturas de un prestador que esten cerradas
     * @return Response $afConciliacion
     * @author JDSS
     */
    public function guardarAuditoriaFinal(Request $request){
        try {
        $glosas = $this->glosaRepository->contadorGlosas($request->af_id);
        $afFinal = $this->facturaRepository->guardarAuditoriaFinal($glosas,$request->af_id);
         return response()->json(['mensaje'=>$afFinal],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Lista las facturas en auditoria final que esten listas para conciliar
     * @return Response $auditadas
     * @author JDSS
     */

     public function facturaConciliadaAuditoriaFinal(Request $request){
        try {
            $auditadas = $this->facturaRepository->facturasConciliadasAuditoriaFinal($request);
            return response()->json($auditadas,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
     }

     /**
     * Lista las facturas en auditoria final que esten listas para conciliar
     * @return Response $auditadas
     * @author JDSS
     */

     public function conciliar(Request $request){
        try {
            // se va a consultar a los repositorios
            $ac = $this->consultaRepository->conciliar($request->af_id);
            $ap = $this->procedimientoRepository->conciliar($request->af_id);
            $at = $this->insumoRepository->conciliar($request->af_id);
            $am = $this->medicamentoRepository->conciliar($request->af_id);
            // se une toda la informacion de los valores que persisten en cada uno de los repositorios para tenerlo en un solo array
            $valorPersiste = array_merge($ac['valorPersisten'], $ap['valorPersisten'],$at['valorPersisten'],$am['valorPersisten']);
            $idGlosas = array_merge($ac['id_glosas'], $ap['id_glosas'],$at['id_glosas'],$am['id_glosas']);
            // teniendo la informacion en un solo array se procede a sumar
            $total = array_sum($valorPersiste);
            return response()->json([
                'total'=>$total,
                'glosa_id'=>$idGlosas,
                'af_id' =>$request->af_id],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
     }


     /**
     * Lista las facturas en auditoria final que esten listas para conciliar con saldo
     * @return Response $auditadas
     * @author JDSS
     */

     public function facturaConciliadaConsaldo(Request $request){
        try {
            $auditadas = $this->facturaRepository->facturasConciliadasConSaldo($request);
            return response()->json($auditadas);
        } catch (\Throwable $th) {
            //throw $th;
        }
     }

     /**
     * Lista las facturas en auditoria final que esten listas para conciliar con saldo
     * @return Response $auditadas
     * @author JDSS
     */

     public function conciliarConSaldo(Request $request){
        try {
            // se va a consultar a los repositorios
            $ac = $this->consultaRepository->conciliarConSaldo($request->af_id);
            $ap = $this->procedimientoRepository->conciliarConSaldo($request->af_id);
            $at = $this->insumoRepository->conciliarConSaldo($request->af_id);
            $am = $this->medicamentoRepository->conciliarConSaldo($request->af_id);
            // se une toda la informacion de los valores que persisten en cada uno de los repositorios para tenerlo en un solo array
            $valorPersiste = array_merge($ac['valorPersisten'], $ap['valorPersisten'],$at['valorPersisten'],$am['valorPersisten']);
            $idGlosas = array_merge($ac['id_glosas'], $ap['id_glosas'],$at['id_glosas'],$am['id_glosas']);
            // teniendo la informacion en un solo array se procede a sumar
            $total = array_sum($valorPersiste);
            return response()->json([
                'total'=>$total,
                'glosa_id'=>$idGlosas,
                'af_id' =>$request->af_id]);
        } catch (\Throwable $th) {
            //throw $th;
        }
     }

     public function facturaCerradas(Request $request){
        try {
         $afConciliacion = $this->facturaRepository->facturaCerradaAuditoriaFinal($request);
         return response()->json($afConciliacion);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al listar'],Response::HTTP_BAD_REQUEST);
        }
    }











}
