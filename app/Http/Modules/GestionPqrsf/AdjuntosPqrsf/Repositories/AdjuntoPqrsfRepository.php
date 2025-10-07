<?php

namespace App\Http\Modules\GestionPqrsf\AdjuntosPqrsf\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\AdjuntosPqrsf\Models\AdjuntoPqrsf;

class AdjuntoPqrsfRepository extends RepositoryBase {

    protected $adjuntoPqrsfModel;

    public function __construct() {
        $this->adjuntoPqrsfModel = new AdjuntoPqrsf();
        parent::__construct($this->adjuntoPqrsfModel);
    }

    public function crearAdjunto($gestion_id,$nombre,$ruta)
    {
        $this->adjuntoPqrsfModel->create([
            'gestion_pqrsf_id' => $gestion_id,
            'nombre' => $nombre,
            'ruta' => $ruta
        ]);
    }





}
