<?php

namespace App\Http\Modules\Zarit\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Zarit\Repositories\zaritRepository;
use App\Http\Modules\Zarit\Services\ZaritService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class zaritController extends Controller
{
    public function __construct(
        private zaritRepository $zaritRepository,
        private ZaritService $zaritService,
    ) {}

    public function crear(Request $request)
    {
        try {
            $data = $request->all();
            $consulta = ['consulta_id' => $data['consulta_id']];

            $this->zaritService->updateOrCreate($consulta, $data);

            return response()->json('Creado o actualizado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $audit = $this->zaritRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($audit, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
