<?php

namespace App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Models\TiposCuentasMedica;

class TipoCuentaMedicaRepository extends RepositoryBase {

    protected $tipoCuentaMedica;

    public function __construct() {
        $this->tipoCuentaMedica = new TiposCuentasMedica();
        parent::__construct($this->tipoCuentaMedica);
    }

}
