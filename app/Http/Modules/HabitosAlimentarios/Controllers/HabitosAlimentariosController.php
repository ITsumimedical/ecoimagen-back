<?php

namespace App\Http\Modules\HabitosAlimentarios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\HabitosAlimentarios\Repositories\HabitosAlimentariosRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HabitosAlimentariosController extends Controller
{
    public function __construct(
        private HabitosAlimentariosRepository $habitosRepository,
    ) {}

    public function crearHabitos(Request $request)
    {
        try {
            $habitos = $this->habitosRepository->crear($request->all());
            return response()->json($habitos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error al crear', $th->getMessage()], 400);
        }
    }

}
