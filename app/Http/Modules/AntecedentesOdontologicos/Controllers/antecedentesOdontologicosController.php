<?php

namespace App\Http\Modules\AntecedentesOdontologicos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\AntecedentesOdontologicos\Repositories\antecedentesOdontologicosRepository;
use App\Http\Modules\AntecedentesOdontologicos\Requests\CrearantecedentesOdontologicosRequests;
use Illuminate\Http\Request;

class antecedentesOdontologicosController extends Controller
{
    public function __construct(
        private antecedentesOdontologicosRepository $antecedentesOdontologicosRepository,
    ) {
    }


    public function crear(CrearantecedentesOdontologicosRequests $request)
    {
        try {
            $this->antecedentesOdontologicosRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Antecedente odontoligico creado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
