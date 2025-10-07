<?php

namespace App\Http\Modules\Medicamentos\Controllers;

use App\Http\Modules\Medicamentos\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Medicamentos\Repositories\BodegaMedicamentoRepository;
use App\Http\Modules\Medicamentos\Repositories\LoteRepository;

class BodegaMedicamentoController extends Controller
{
    public function __construct(private BodegaMedicamentoRepository $bodegaMedicamentoRepository, private LoteRepository $loteRepository)
    {
    }


    /**
     * Listar todos los bodegasmedicamnto  por bodega y medicento con el fin de saber el total que se le puede aprobar y de que lote
     *
     * @return void
     * @author jdss
     */
    public function consultar (Request $request){
        try {
            $bodegas = $this->bodegaMedicamentoRepository->consultarBodega($request->all());
            return response()->json($bodegas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarLote($id, Request $request){
        try {
            $estado = $this->loteRepository->buscar($id);
            $estado->fill($request->all());
            $this->loteRepository->guardar($estado);
            return response()->json([
                'mensaje' => 'Estado actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar estado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inventario(Request $request){
        try {
            $inventario = $this->bodegaMedicamentoRepository->inventario($request->bodega_id);
            return response()->json($inventario, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * exporta el archivo de saldos
     * @param Request $request
     * @return Response
     */
    public function exportar(Request $request){
        try {
            $consulta = $this->bodegaMedicamentoRepository->exportar($request->bodega_id === 'null' ? 0 : intval($request->bodega_id));
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode() ?: Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarLote(Request $request){
        try {
            $lote = $this->loteRepository->buscarLote($request->all());
            return response()->json($lote, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function loteDisponibleDispensacion($bodega,$articulo)
    {
        $lotes = Lote::with('bodegaMedicamento','bodegaMedicamento.medicamento','bodegaMedicamento.medicamento.invima')
            ->where('cantidad','>',0)
            ->whereHas('bodegaMedicamento', function($q) use ($bodega){
                return $q->where('bodega_id',$bodega );
            })
            ->whereHas('bodegaMedicamento.medicamento', function($q) use ($articulo){
                return $q->where('codesumi_id',$articulo);
            })->get();
        return response()->json($lotes);
    }

    public function listar(Request $request){
        try {
            $areas = $this->bodegaMedicamentoRepository->listarBodega($request);
            return response()->json($areas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guardar un medicamento a varias bodegas
     *
     * @return void
     * @author kobatime
     */
    public function guardar(Request $request){
        try {
            $bodegas = $this->bodegaMedicamentoRepository->guardarBodega($request->all());
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function buscarLoteMedicamentoEntrada(Request $request){
        try {
            $ajuste = $this->loteRepository->loteMedicamentoEntrada($request->all());
            return response()->json($ajuste, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function buscarLoteMedicamentoSalida(Request $request){
        try {
            $ajuste = $this->loteRepository->loteMedicamentoSalida($request->all());
            return response()->json($ajuste, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function bodegaEntrada(int $bodega_id){
        try {
            $listadoMedicamentos = $this->bodegaMedicamentoRepository->medicamentosEntrada($bodega_id);
            return response()->json($listadoMedicamentos, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function bodegaSalida(int $bodega_id){
        try {
            $listadoMedicamentos = $this->bodegaMedicamentoRepository->medicamentosSalida($bodega_id);
            return response()->json($listadoMedicamentos, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function consultarTraslados (Request $request){
        try {
            $bodegas = $this->bodegaMedicamentoRepository->consultarBodegaTraslado($request->all());
            return response()->json($bodegas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inactivar(Request $request){
        try {
            $bodegas = $this->bodegaMedicamentoRepository->inactivar($request->all());
            return response()->json($bodegas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
