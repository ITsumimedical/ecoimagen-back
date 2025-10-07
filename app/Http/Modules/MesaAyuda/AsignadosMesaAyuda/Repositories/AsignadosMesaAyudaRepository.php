<?php

namespace App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Models\AsignadosMesaAyuda;

class AsignadosMesaAyudaRepository extends RepositoryBase{

    public function __construct(protected AsignadosMesaAyuda $asignadosMesaAyudaModel){
        parent::__construct($this->asignadosMesaAyudaModel);
    }

    public function crearAsignado($mesaAyuda,$usuario,$categoria){
      return  $this->asignadosMesaAyudaModel->create([
            'mesa_ayuda_id' => $mesaAyuda,
            'user_id' => $usuario,
            'categoria_mesa_ayuda_id' => $categoria,

        ]);
    }

    public function quitarRegistro($mesaAyuda_id){
        $this->asignadosMesaAyudaModel->where('mesa_ayuda_id',$mesaAyuda_id)->update(['estado_id'=>2]);
    }


}
