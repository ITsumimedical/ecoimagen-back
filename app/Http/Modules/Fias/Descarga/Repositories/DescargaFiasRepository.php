<?php

namespace App\Http\Modules\Fias\Descarga\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Fias\Descarga\Models\DescargaFiasModel;
use App\Http\Modules\Fias\Descarga\Services\DescargaFiasService;

class DescargaFiasRepository extends RepositoryBase {

    protected $descargaFiasModel;

    public function __construct() {
        $this->descargaFiasModel = new DescargaFiasModel();
        parent::__construct($this->descargaFiasModel);
    }

    public function descargar(Request $request){


        $service = new DescargaFiasService();
        $instancia = $service->determinarFias($request->all());

        $guardar = $service->guardarFias($request->all(),$instancia);
        return $instancia;

    }
}
