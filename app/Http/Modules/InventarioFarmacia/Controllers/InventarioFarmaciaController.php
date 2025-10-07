<?php

namespace App\Http\Modules\InventarioFarmacia\Controllers;

use App\Http\Modules\ConteoInventario\Models\ConteoInventario;
use App\Http\Modules\InventarioFarmacia\Models\InventarioFarmacia;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Lote;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;
use App\Http\Modules\Movimientos\Models\Movimiento;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\InventarioFarmacia\Repositories\InventarioFarmaciaRepository;
use App\Http\Modules\InventarioFarmacia\Requests\CrearInventarioFarmaciaRequest;
use App\Http\Modules\InventarioFarmacia\Services\InventarioFarmaciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class InventarioFarmaciaController extends Controller
{

    public function __construct(protected InventarioFarmaciaRepository $inventarioRepository,
                                protected InventarioFarmaciaService $inventarioFarmaciaService)
    {
    }

    public function registrarInventario(CrearInventarioFarmaciaRequest $request)//: JsonResponse
    {
        try {
            $inventario = $this->inventarioFarmaciaService->registro($request->validated());
            return response()->json($inventario, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inventarioActivo()//: JsonResponse
    {
        try {
            $inventarioActivo = $this->inventarioRepository->inventarioActivo();
            return response()->json($inventarioActivo, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar inventarios activos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detalleInventarioActivo($id)
    {
        try {
            $inventarioActivo = $this->inventarioRepository->detalleInventarioActivo($id);
            return response()->json($inventarioActivo, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar inventarios activos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function finalizarConteo1(Request $request)
    {
        foreach ($request->all() as $detalle){
            $conteo = ConteoInventario::find($detalle['id']);
            $conteo->conteo1 = intval($detalle['conteo1']);
            if($conteo->conteo1 === intval($detalle['cantidad'])){
                $conteo->value1 = intval($conteo['conteo1']);
            }
            $conteo->save();
        }
        $inventario = InventarioFarmacia::with('bodega')->find($request[0]['inventario_farmacia_id']);
        $inventario->estado_id = 40;
        $inventario->save();
        return response()->json(['mensaje' => 'Conteo 1 cerrado con exito!','cabecera' => $inventario]);
    }

    public function finalizarConteo2(Request $request)
    {
        foreach ($request->all() as $detalle){
            $conteo = ConteoInventario::find($detalle['id']);
            $conteo->conteo2 = intval($detalle['conteo2']);
            if(intval($conteo['conteo1']) === intval($conteo['conteo2']) || intval($conteo['conteo2']) === intval($detalle['cantidad']) ){
                $conteo->value1 = intval($conteo['conteo2']);
            }
            $conteo->save();
        }
        $inventario = InventarioFarmacia::with('bodega')->find($request[0]['inventario_farmacia_id']);
        $inventario->estado_id = 41;
        $inventario->save();
        return response()->json(['mensaje' => 'Conteo 2 cerrado con exito!','cabecera' => $inventario]);
    }

    public function finalizarConteo3(Request $request)
    {
        $totalConteos3 = array_filter($request->all(), function($v, $k) {
             return isset($v['conteo3']);
        }, ARRAY_FILTER_USE_BOTH);
        foreach ($totalConteos3 as $detalle){
            ConteoInventario::find($detalle['id'])->update(['conteo3' => $detalle['conteo3'],'value1' => $detalle['conteo3']]);
        }
        $inventario = InventarioFarmacia::with('bodega')->find($request[0]['inventario_farmacia_id']);
        $inventario->estado_id = 22;
        $inventario->save();
        return response()->json(['mensaje' => 'Conteo 3 cerrado con exito!','cabecera' => $inventario]);
    }


    public function finalizarInventario($id)
    {
        $inventario = InventarioFarmacia::find($id);
        Lote::join('bodega_medicamentos as bm','bm.id','lotes.bodega_medicamento_id')
            ->where('bm.bodega_id',$inventario->bodega_id)
            ->update(['lotes.cantidad' => 0]);
        $movimiento = Movimiento::create([
            'tipo_movimiento_id' => 16,
            'bodega_origen_id' => $inventario->bodega_id,
            'user_id' => Auth::id(),
        ]);
        $conteos = ConteoInventario::where('inventario_farmacia_id',$id)->whereNotNull('value1')->get();
        foreach ($conteos as $conteo){
            $lote = Lote::find($conteo['lote_id']);
            $lote->cantidad = $conteo['value1'];
            $lote->save();
            DetalleMovimiento::create([
                'movimiento_id' => $movimiento->id,
                'bodega_medicamento_id' => $lote->bodega_medicamento_id,
                'cantidad_anterior' => $conteo['saldo_inicial'],
                'cantidad_solicitada' => $conteo['value1'],
                'cantidad_final' => $conteo['value1'],
                'lote_id' => $lote->id
            ]);
        }
        return response()->json(['mensaje' => 'Inventario finalizado!']);
    }

    public function guardarProgreso(Request $request,$id)
    {
        $campo = [
          '1' => 'conteo1',
          '40' => 'conteo2',
          '41' => 'conteo3'
        ];
        foreach ($request->all() as $key => $dato){
            $conteo = ConteoInventario::find($key);
            $conteo->{$campo[strval($id)]} = intval($dato);
            $conteo->save();
        }
        return response()->json(['mensaje' => 'Registros Guardados!']);
    }

    public function medicamentosBodega($bodega,$medicamento)
    {
        $medicamentos = Medicamento::without('invima','codesumi')->select(
            'medicamentos.id',
            DB::raw("CONCAT(medicamentos.cum,'-',c.producto,' (',cs.nombre,')') as nombre")
        )->join('cums as c' ,'medicamentos.cum','c.cum_validacion')
            ->join('codesumis as cs','cs.id','medicamentos.codesumi_id')
            ->where('c.producto','LIKE','%'.strtoupper($medicamento).'%')
            ->orWhere('medicamentos.cum','LIKE','%'.$medicamento.'%')
            ->orWhere('cs.nombre','LIKE','%'.strtoupper($medicamento).'%')
            ->distinct()
            ->get();

        return response()->json($medicamentos->toArray());
    }

    public function buscarLotes0($inventario,$id)
    {
        $inventarioFarmacia = InventarioFarmacia::find($inventario);
        return response()->json(
            Lote::select('lotes.*')->join('bodega_medicamentos as bm','bm.id','lotes.bodega_medicamento_id')
            ->where('bodega_id',$inventarioFarmacia->bodega_id)
            ->where('medicamento_id',$id)
            ->where('cantidad',0)
                ->whereNotIn('lotes.id',function ($q) use ($inventario){
                    $q->select('lote_id')
                        ->from('conteo_inventarios')
                        ->where('inventario_farmacia_id',$inventario);
                })
            ->get()
        );
    }

    public function agregarLote(Request $request,$id)
    {
        $inventario = InventarioFarmacia::find($id);
        $conteo = null;
        if($request->loteExistente){
            $conteo = ConteoInventario::create([
                'lote_id' => $request->loteExistente,
                'user_id' => Auth::id(),
                'estado_id' => 1,
                'inventario_farmacia_id' => $inventario->id
            ]);
        }else{
            $bodegaMedicamentos = BodegaMedicamento::where('medicamento_id',$request->medicamento)
                ->where('bodega_id',$inventario->bodega_id)->first();
            if(!$bodegaMedicamentos){
                $bodegaMedicamentos = BodegaMedicamento::create([
                    'medicamento_id' => $request->medicamento,
                    'bodega_id' => $inventario->bodega_id
                ]);
            }
            $lote = Lote::create([
                'codigo' => $request->lote,
                'cantidad' => 0,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'bodega_medicamento_id' => $bodegaMedicamentos->id,
                'estado_id' => 1
            ]);
            $conteo = ConteoInventario::create([
                'lote_id' => $lote->id,
                'user_id' => Auth::id(),
                'estado_id' => 1,
                'inventario_farmacia_id' => $inventario->id
            ]);


        }
        $registro = ConteoInventario::select('conteo_inventarios.*','m.codigo_medicamento','c.producto','l.codigo','c.titular','l.cantidad','l.fecha_vencimiento')
            ->leftjoin('lotes as l','conteo_inventarios.lote_id','l.id')
            ->leftjoin('bodega_medicamentos as bm','l.bodega_medicamento_id','bm.id')
            ->leftjoin('medicamentos as m','bm.medicamento_id','m.id')
            ->leftjoin('cums as c','m.cum','c.cum_validacion')
            ->where('conteo_inventarios.id',$conteo->id)
            ->distinct()
            ->orderBy('conteo_inventarios.id')
            ->first();

        return response()->json($registro);

    }

    public function inventarios(Request $request)
    {
        try {
            $inventarios = InventarioFarmacia::with('bodega','estado')->get();
            return response()->json($inventarios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar inventarios activos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reporteDetalle($id)
    {
        try {
            $reporte = DB::select("SELECT * FROM fn_conteos_inventario(" . intval($id) . ")");
            return (new FastExcel($reporte))->download('file.xls');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al generar reporte de conteos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
