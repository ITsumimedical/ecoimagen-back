<?php
namespace App\Http\Modules\CobroServicios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Contratos\Services\ContratoService;

class cobroServicioController extends Controller
{
    public function __construct(protected ContratoService $contratoService){

    }

    public function acumuladoAnual($afiliado){
        try {
            $acumulado = $this->contratoService->acumuladoAnualInformativo($afiliado);
            return response()->json($acumulado);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}