<?php

namespace App\Http\Modules\Patologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Patologia\Repositories\AntecedentesPatologiaRepository;
use App\Http\Modules\Patologia\Requests\CrearAntecedentesPatologiaRequest;
use Illuminate\Http\Response;

class PatologiaController extends Controller
{
    public function __construct(protected AntecedentesPatologiaRepository $patologiaRepository)
    {
    }

    public function crear(CrearAntecedentesPatologiaRequest $request)
    {
        try {
         $patologia = $this->patologiaRepository->crear($request->validated());
            return response()->json([
                 'data' => $patologia,
                'mensaje' => 'La patologia fue registrado con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la patologia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
