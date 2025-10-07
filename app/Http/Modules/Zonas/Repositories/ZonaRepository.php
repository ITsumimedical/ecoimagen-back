<?php

namespace App\Http\Modules\Zonas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Zonas\Models\Zonas;

class ZonaRepository extends RepositoryBase
{
    protected $zonaModel;

    public function __construct()
    {
        $this->zonaModel = new Zonas();
        parent::__construct($this->zonaModel);
    }

    /**
     * Crea un nuevo tipo de ruta
     * @param array $data
     * @return Zonas
     * @author jose v
     */
    public function crearZona($data)
    {
        $crear = $this->zonaModel->create($data);
        return $crear;
    }

    public function listarZonas()
    {
        return $this->zonaModel->get();
    }


}
