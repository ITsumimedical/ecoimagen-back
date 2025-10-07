<?php

namespace App\Http\Modules\Codesumis\viasAdministracion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Codesumis\viasAdministracion\Model\viasAdministracion;
use Illuminate\Http\Request;

class viasAdministracionRepository extends RepositoryBase
{

    protected $vias;

    public function __construct()
    {
        $this->vias = new viasAdministracion();
        parent::__construct($this->vias);
    }

    public function listarVias(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $via = $this->vias->select(
            'vias_administracion.id',
            'vias_administracion.nombre',
            'vias_administracion.codigo'
        );

        if ($request->has('page')) {
            return $via->paginate($cantidad);
        } else {
            return $via->get();
        }
    }

    public function actualizar($id, $data)
    {
        $via = $this->vias->find($id);

        if (!$via) {
            throw new \Exception("La vía de administración no existe");
        }

        $via->update($data);
        return $via;
    }
}
