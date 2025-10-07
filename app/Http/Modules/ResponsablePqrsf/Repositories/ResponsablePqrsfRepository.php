<?php

namespace App\Http\Modules\ResponsablePqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ResponsablePqrsf\Models\ResponsablePqrsf;

class ResponsablePqrsfRepository extends RepositoryBase{



    public function __construct(private ResponsablePqrsf $responsablePqrsfModel) {
        parent::__construct($this->responsablePqrsfModel);

    }

    public function listarReponsable($request) {
        $consulta =  $this->responsablePqrsfModel->with('user')->where('activo', true);

        return $request->page ? $consulta->paginate() : $consulta->get();
    }
    public function listarTodos($request) {
        $consulta =  $this->responsablePqrsfModel->with('user');

        return $request->page ? $consulta->paginate() : $consulta->get();
    }

    public function cambiarEstado($id) {
        $responsable = $this->responsablePqrsfModel->find($id);

        if ($responsable) {
            $responsable->activo = !$responsable->activo;
            $responsable->save();
            return $responsable;
        }

        return null;
    }

}
