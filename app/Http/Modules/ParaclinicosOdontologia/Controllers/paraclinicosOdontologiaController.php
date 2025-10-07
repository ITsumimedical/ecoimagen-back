<?php

namespace App\Http\Modules\ParaclinicosOdontologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ParaclinicosOdontologia\Repositories\paraclinicosOdontologiaRepository;
use Illuminate\Http\Request;

class paraclinicosOdontologiaController extends Controller
{
    public function __construct(
        private paraclinicosOdontologiaRepository $paraclinicosOdontologiaRepository,
    ) {
    }

    public function crear(Request $request)
    {
        try {
            $this->paraclinicosOdontologiaRepository->crear($request->all());
            return response()->json([
                'mensaje' => 'paraclinico guardado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
