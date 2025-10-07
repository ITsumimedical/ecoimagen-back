<?php

namespace App\Http\Modules\InventarioFarmacia\Services;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\ConteoInventario\Models\ConteoInventario;
use App\Http\Modules\InventarioFarmacia\Models\InventarioFarmacia;
use App\Http\Modules\InventarioFarmacia\Repositories\InventarioFarmaciaRepository;
use App\Http\Modules\Medicamentos\Models\Lote;
use Illuminate\Support\Facades\Auth;

class InventarioFarmaciaService {

    public function __construct(protected InventarioFarmaciaRepository $inventarioFarmaciaRepository)
    {
    }

    public function registro($data){
      $bodegaEnInventario = InventarioFarmacia::where('bodega_id', $data['bodega_id'])->whereIn('estado_id', [1,40,41])->first();
      if ($bodegaEnInventario) {
          trigger_error("La bodega seleccionada ya se encuentra en un proceso de conteo", E_USER_ERROR);
      }else {
         $inventario = InventarioFarmacia::create([
              'bodega_id' => $data['bodega_id'],
              'realizado_por' => Auth::id(),
              'estado_id' => 1
         ]);
         $lotes = Lote::select('lotes.id as lote','lotes.cantidad as cantidad')->join('bodega_medicamentos as bm','bm.id','lotes.bodega_medicamento_id')
             ->where('bm.bodega_id',$inventario->bodega_id)
             ->where('lotes.cantidad','>',0)
             ->get()->toArray();
        $loteDb = array_map(
            function ($data) use ($inventario) {
                $array = [
                    'inventario_farmacia_id' => $inventario->id,
                    'user_id' => Auth::id(),
                    'estado_id' => 1,
                    'lote_id' => $data['lote'],
                    'saldo_inicial' => $data['cantidad']
                ];
                return $array;
            },
            $lotes
        );
        foreach (array_chunk($loteDb, 500) as $chunk) {
            ConteoInventario::insert($chunk);
        }
        return $this->inventarioFarmaciaRepository->detalleInventarioActivo($inventario->id);
      }

    }

}
