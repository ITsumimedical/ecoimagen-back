<?php

namespace App\Http\Modules\sindromesGeriatricos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\sindromesGeriatricos\Repositories\SindromesGeriatricosRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SindromesGeriatricosController extends Controller
{
    public function __construct(
        private SindromesGeriatricosRepository $sindromeRepository,
    ) {

    }

    public function crearSindrome(Request $request)
    {
        try {
            $sindrome = $this->sindromeRepository->actualizarOcrearSindrome($request->all());
            return response()->json($sindrome, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
