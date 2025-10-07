<?php

namespace App\Http\Modules\DetalleSolicitudBodegas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DetalleSolicitudBodegas\Models\SolicitudDetalleBodegaLote;

class SolicitudDetalleBodegaLoteRepository extends RepositoryBase {

    protected $detalleSolicitudModel;

    public function __construct(){
        $this->detalleSolicitudModel = new SolicitudDetalleBodegaLote();
        parent::__construct($this->detalleSolicitudModel);
     }

     public function crearSolicitud($detalleSolicitud_id,$lote_id,$cantidad)
     {
        return $this->detalleSolicitudModel->create([
            'detalle_solicitud_bodega_id' => $detalleSolicitud_id,
            'lote' => $lote_id,
            'cantidad'=> $cantidad,
        ]);
     }
}
