<?php

namespace App\Http\Modules\Citas\Controllers;

use App\Http\Modules\Citas\Repositories\ModalidadRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ModalidadController extends Controller
{

    public function __construct(protected ModalidadRepository $modalidadRepository)
    {
    }

    /**
     * lista las modalidades
     *
     * @return void
     * @author Torres
     */
    public function listar(Request $request)
    {
        try {
            $modalidad = $this->modalidadRepository->listar($request);
            return response()->json($modalidad, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
