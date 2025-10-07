<?php

namespace App\Http\Modules\CierreMesContratosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CierreMesContratosEmpleados\Repositories\CierreMesContratoEmpleadoRepository;

class CierreMesContratoEmpleadoController extends Controller
{
    private $cierreMesRepository;

    public function __construct(){
        $this->cierreMesRepository = new CierreMesContratoEmpleadoRepository();
    }

    public function listar(Request $request)
    {
        try {
            $cierre = $this->cierreMesRepository->listarCierres($request);
            return response()->json($cierre, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los cierres de mes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
