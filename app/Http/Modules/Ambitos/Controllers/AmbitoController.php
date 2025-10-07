<?php

namespace App\Http\Modules\Ambitos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Ambitos\Repositories\AmbitoRepository;
use App\Http\Modules\Ambitos\Requests\GuardarAmbitoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AmbitoController extends Controller
{
    private $ambitoRepository;

    public function __construct()
    {
        $this->ambitoRepository = new AmbitoRepository;
    }

    /**
     * lista las ámbito
     *
     * @return void
     */
    public function listar(Request $request){
        try {
            $ambitos = $this->ambitoRepository->listar($request);
            return response()->json( $ambitos, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda un ámbito
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function guardar(GuardarAmbitoRequest $request): JsonResponse
    {
        try {
            $nuevoAmbito = $this->ambitoRepository->guardar($request->validated());
            return response()->json($nuevoAmbito, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * actualiza un ámbito según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(GuardarAmbitoRequest $request, Ambito $id): JsonResponse
    {
        try {
            $ambito = $this->ambitoRepository->actualizar($id, $request->validated());
            return response()->json($ambito, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


}
