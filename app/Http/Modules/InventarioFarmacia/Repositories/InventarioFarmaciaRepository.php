<?php

namespace App\Http\Modules\InventarioFarmacia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConteoInventario\Models\ConteoInventario;
use App\Http\Modules\InventarioFarmacia\Models\InventarioFarmacia;

class InventarioFarmaciaRepository extends RepositoryBase
{

    public function __construct(protected InventarioFarmacia $inventarioFarmaciaModel)
    {
        parent::__construct($inventarioFarmaciaModel);
    }

    public function inventarioActivo() {
        return InventarioFarmacia::select('inventario_farmacias.id', 'estados.nombre as estado','inventario_farmacias.bodega_id', 'inventario_farmacias.created_at', 'bodegas.nombre')
                // ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as nombre_completo")
                ->join('estados', 'inventario_farmacias.estado_id', 'estados.id')
                ->join('bodegas', 'inventario_farmacias.bodega_id', 'bodegas.id')
                // ->leftjoin('empleados', 'inventario_farmacias.realizado_por', 'empleados.user_id')
                ->whereIn('inventario_farmacias.estado_id',[1,40,41])
                ->get();
    }

    public function detalleInventarioActivo($id)
    {
        $datosDetalles = [
            'cabecera' => InventarioFarmacia::with('bodega')->find($id),
            'detalles' => ConteoInventario::select('conteo_inventarios.*','m.codigo_medicamento','codesumis.nombre as producto','l.codigo','c.titular','l.cantidad','l.fecha_vencimiento')
                ->leftjoin('lotes as l','conteo_inventarios.lote_id','l.id')
                ->leftjoin('bodega_medicamentos as bm','l.bodega_medicamento_id','bm.id')
                ->leftjoin('medicamentos as m','bm.medicamento_id','m.id')
                ->leftjoin('cums as c','m.cum','c.cum_validacion')
                ->leftjoin('codesumis','codesumis.id','m.codesumi_id')
                ->where('conteo_inventarios.inventario_farmacia_id',$id)
                ->distinct()
                ->orderBy('conteo_inventarios.id')
                ->get(),
        ];
        return $datosDetalles;
    }

}
