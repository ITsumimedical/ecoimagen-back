<?php

namespace App\Http\Modules\Areas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Areas\Models\Area;
use App\Http\Modules\Areas\Repositories\AreaRepository;
use App\Http\Modules\Areas\Requests\GuardarAreaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    private $areaRepository;

    public function __construct()
    {
        $this->areaRepository = new AreaRepository;
    }

    /**
     * lista las áreas
     *
     * @return void
     */
    public function listar(Request $request){
        try {
            $areas = $this->areaRepository->listar($request);
            return response()->json($areas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda un área
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function guardar(GuardarAreaRequest $request): JsonResponse
    {
        try {
            $nuevaArea = $this->areaRepository->guardar($request->validated());
            return response()->json($nuevaArea, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * actualiza un área según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(GuardarAreaRequest $request, Area $id): JsonResponse
    {
        try {
            $area = $this->areaRepository->actualizar($id, $request->validated());
            return response()->json($area, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


}
