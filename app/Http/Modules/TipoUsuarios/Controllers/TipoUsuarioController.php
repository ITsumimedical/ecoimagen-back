<?php

namespace App\Http\Modules\TipoUsuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoUsuarios\Repositories\TipoUsuarioRepository;
use Illuminate\Http\Request;

class TipoUsuarioController extends Controller
{
    private $TipoUsuarioRepository;

    public function __construct()
    {
        $this->TipoUsuarioRepository = new TipoUsuarioRepository();
    }

    public function listar(Request $request)
    {
        try {
            $tipoUsuario = $this->TipoUsuarioRepository->listarTipoUsuario($request);
            return response()->json([
                'res' => true,
                'data' => $tipoUsuario
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al consultar los tipos de usuarios'
            ], 400);
        }
    }

    public function listarTodos(Request $request)
    {
        try {
            $tiposUsuario = $this->TipoUsuarioRepository->listar($request);

            return response()->json($tiposUsuario, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al consultar todos los tipos de usuarios'
            ], 400);
        }
    }
}
