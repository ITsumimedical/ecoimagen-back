<?php

namespace App\Http\Modules\RecibeQuimioterapia\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\RecibeQuimioterapia\Repositories\RecibeQuimioterapiaRepository;
use App\Http\Modules\RecibeQuimioterapia\Requests\CrearRecibeQuimioterapiaRequest;
use Illuminate\Http\Request;

class RecibeQuimioterapiaController extends Controller
{
     public function __construct(
        protected RecibeQuimioterapiaRepository $recibeQuimioterapiaRepository,
    ) {}

        public function crearQuimioterapia(CrearRecibeQuimioterapiaRequest $request)
        {
            try {
                $quimioterapia = $this->recibeQuimioterapiaRepository->crear($request->validated());
                return response()->json($quimioterapia);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()], 400);
            }
        }

        public function listarQuimioterapiaPorAfiliado($afiliado_id)
        {
            try {
                $quimioterapia = $this->recibeQuimioterapiaRepository->listarQuimioterapiasPorAfiliado($afiliado_id);
                return response()->json($quimioterapia);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()], 400);
            }
        }

        public function eliminarQuimioterapia($id)
        {
            try {
                $this->recibeQuimioterapiaRepository->eliminar($id);
                return response()->json(['mensaje' => 'Quimioterapia eliminada correctamente']);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()], 400);
            }
        }
}
