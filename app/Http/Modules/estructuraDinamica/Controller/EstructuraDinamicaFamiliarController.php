<?php

namespace App\Http\Modules\estructuraDinamica\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\estructuraDinamica\Repositories\EstructuraDinamicaFamiliarRepository;
use Illuminate\Http\Request;

class EstructuraDinamicaFamiliarController extends Controller
{
    public function __construct(
        protected EstructuraDinamicaFamiliarRepository $estructuraDinamicaFamiliarRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $estructura = $this->estructuraDinamicaFamiliarRepository->crearEstructura($request->all());
            return response()->json($estructura);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
