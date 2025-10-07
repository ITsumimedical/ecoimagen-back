<?php

namespace App\Http\Modules\Proveedores\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Proveedores\Models\Proveedor;

class ProveedorRepository extends RepositoryBase {

    protected $proveedorModel;

    public function __construct(){
        $this->proveedorModel = new Proveedor();
        parent::__construct($this->proveedorModel);
    }
}
