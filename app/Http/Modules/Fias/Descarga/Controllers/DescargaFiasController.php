<?php

namespace App\Http\Modules\Fias\Descarga\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Fias\Descarga\Repositories\DescargaFiasRepository;
use App\Http\Modules\Fias\Descarga\Services\DescargaFiasService;

class DescargaFiasController extends Controller
{
    private $descargaRepository;

    public function __construct(DescargaFiasRepository $descargaRepository){
       $this->descargaRepository = $descargaRepository;
    }

    /**
     * reporte descarga procedimiento almacenado de la base de datos
     *
     * @param  mixed $request
     * @return void
     */
    public function descargar(Request $request){


        $service = new DescargaFiasService();
        $instancia = $service->determinarFias($request->all());

        $guardar = $service->guardarFias($request->all(),$instancia);
        // return $instancia;
        return $instancia;

    }

}
