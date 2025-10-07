<?php

namespace App\Http\Modules\IngresoDomiciliarios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\IngresoDomiciliarios\Models\IngresoDomiciliario;
use Illuminate\Http\Request;

class IngresoDomiciliarioRepository extends RepositoryBase
{
    protected $ingresoDomiciliarioModel;

    public function __construct()
    {
        $this->ingresoDomiciliarioModel = new IngresoDomiciliario();
        parent::__construct($this->ingresoDomiciliarioModel);
    }

    /**
     * cambiar el estado de un ingreso domiciliario
     *
     * @param  mixed $request
     * @param  mixed $estado_id
     * @return void ->estado actualizado
     * @author Manuela
     */
    public function cambiarEstado(Request $request, $estado_id)
    {
        $estado = IngresoDomiciliario::find($estado_id);
        $estado['estado_id'] = $request['estado_id'];
        $estado = $estado->update();
        return $estado;
    }
}
