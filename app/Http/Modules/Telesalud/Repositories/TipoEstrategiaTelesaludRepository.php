<?php


namespace App\Http\Modules\Telesalud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Telesalud\Models\TipoEstrategiaTelesalud;

class TipoEstrategiaTelesaludRepository extends RepositoryBase
{
    protected $tipoEstrategiaModel;

    public function __construct()
    {
        $this->tipoEstrategiaModel = new TipoEstrategiaTelesalud();
        parent::__construct($this->tipoEstrategiaModel);
    }

    /**
     * Obtiene todos los tipos de estrategias activos
     * @return TipoEstrategiaTelesalud[]
     * @author Thomas
     */
    public function listarActivos()
    {
        return $this->tipoEstrategiaModel->where("activo", true)->get();
    }
}
