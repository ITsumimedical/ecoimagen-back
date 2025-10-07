<?php

namespace App\Http\Modules\Referencia\AdjuntosReferencia\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Referencia\AdjuntosReferencia\Models\AdjuntoReferencia;

class AdjuntosReferenciaRepository extends RepositoryBase {

    public function __construct(protected AdjuntoReferencia $adjuntoReferenciaModel) {
        parent::__construct($this->adjuntoReferenciaModel);
    }

    public function crearAdjunto($ruta,$nombre,$id){
        $this->adjuntoReferenciaModel::create(['ruta'=>$ruta,'nombre'=>$nombre,'referencia_id'=>$id]);
    }

    public function crearAdjuntoUrgencia($ruta,$nombre,$id){
        return DB::connection('secondary')->table('adjunto_referencias')->insert([
            'ruta'=>$ruta,
            'nombre'=>$nombre,
            'referencia_id'=>$id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }



}
