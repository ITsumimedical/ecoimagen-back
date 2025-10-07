<?php

namespace App\Http\Modules\Whooley\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Whooley\Repositories\whooleyRepository;
use App\Http\Modules\Whooley\Services\WhooleyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class whooleyController extends Controller
{
    public function __construct(
        private whooleyRepository $whooleyRepository,
        private WhooleyService $whooleyService,
    ) {}

    public function crear(Request $request)
    {
        try {
            $data = $request->all();

            $this->whooleyService->updateOrCreate(
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
            $whooley = $this->whooleyRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($whooley, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
