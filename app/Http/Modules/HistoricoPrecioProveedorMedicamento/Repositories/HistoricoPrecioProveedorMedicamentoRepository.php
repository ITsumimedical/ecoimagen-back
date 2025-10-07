<?php

namespace App\Http\Modules\HistoricoPrecioProveedorMedicamento\Repositories;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\HistoricoPrecioProveedorMedicamento\Models\HistoricoPrecioProveedorMedicamento;

class HistoricoPrecioProveedorMedicamentoRepository extends RepositoryBase {

    public function __construct(protected HistoricoPrecioProveedorMedicamento $historicoPrecioProveedorMedicamentoModel) {
        parent::__construct($this->historicoPrecioProveedorMedicamentoModel);
    }

    public function importarExcel($data) {
        $excel = $this->historicoPrecioProveedorMedicamentoModel::select('historico_precio_proveedor_medicamentos.id',
        'codesumis.nombre','codesumis.codigo',
        'cums.titular as Fabricante',
        'cums.unidad_referencia',
        // 'detalle_solicitud_bodegas.cantidad_inicial',
        'solicitud_bodegas.id as idD',
        'historico_precio_proveedor_medicamentos.precio_unidad as Valor unidad')
        // ->selectRaw('(historico_precio_proveedor_medicamentos.precio_unidad * detalle_solicitud_bodegas.cantidad_inicial) as Total')
        ->join('solicitud_bodegas','solicitud_bodegas.id','historico_precio_proveedor_medicamentos.solicitud_bodega_id')
        ->join('detalle_solicitud_bodegas','detalle_solicitud_bodegas.solicitud_bodega_id','solicitud_bodegas.id')
        ->join('medicamentos','medicamentos.id','historico_precio_proveedor_medicamentos.medicamento_id')
        ->join('codesumis','codesumis.id','medicamentos.codesumi_id')
        ->join('cums','cums.cum_validacion','medicamentos.cum')
        ->where('historico_precio_proveedor_medicamentos.solicitud_bodega_id',$data['id'])
        // ->where('detalle_solicitud_bodegas.estado_id',14)
        ->distinct()
        ->get()->toArray();
        return (new FastExcel($excel))->download('informe.xls');
    }
}
