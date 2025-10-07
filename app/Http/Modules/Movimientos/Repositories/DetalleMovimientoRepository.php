<?php

namespace App\Http\Modules\Movimientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Movimientos\Models\DetalleMovimiento;

class DetalleMovimientoRepository extends RepositoryBase {

    protected $detalleSolicitudModel;

    public function __construct(){
        $this->detalleSolicitudModel = new DetalleMovimiento();
        parent::__construct($this->detalleSolicitudModel);
     }

     public function guardarDetalleMovimientoTraslado($movimiento_id,$cantidadSolicitada,$cantidadAnterior,$bodega,$lote){
        return $this->detalleSolicitudModel->create([
            'movimiento_id' => $movimiento_id,
            'bodega_medicamento_id' => $bodega['id'],
            'cantidad_anterior'=> $cantidadAnterior,
            'cantidad_solicitada' => $cantidadSolicitada,
            'lote_id' =>$lote,
            'cantidad_final' => $bodega['cantidad_total']
        ]);
    }


}
