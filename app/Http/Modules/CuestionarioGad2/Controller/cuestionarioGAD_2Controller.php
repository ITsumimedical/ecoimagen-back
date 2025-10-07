<?php

namespace App\Http\Modules\CuestionarioGad2\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\CuestionarioGad2\Repositories\cuestionarioGAD_2Repository;
use App\Http\Modules\CuestionarioGad2\Services\CuestionarioGad2Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class cuestionarioGAD_2Controller extends Controller
{
    public function __construct(
        private cuestionarioGAD_2Repository $cuestionarioGAD_2Repository,
        private CuestionarioGad2Service $cuestionarioGAD_2Service,
    ) {}


    public function crear(Request $request)
    {
        try {
            $data = $request->all();
            $this->cuestionarioGAD_2Service->updateOrCreate(
                ['consulta_id' => $data['consulta_id']],
                $data
            );

            return response()->json('Creado o actualizado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function obtenerDatos($afiliadoId)
    {
        try {
            $nivelKaiser = $this->cuestionarioGAD_2Repository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($nivelKaiser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
