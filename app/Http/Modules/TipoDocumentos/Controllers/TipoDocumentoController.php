<?php

namespace App\Http\Modules\TipoDocumentos\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoDocumentos\Repositories\TipoDocumentosRepository;

class TipoDocumentoController extends Controller
{
    private $tipoDocumentoRepository;

    public function __construct() {
        $this->tipoDocumentoRepository = new TipoDocumentosRepository();
    }

    public function listar(Request $request)
    {
        try {
            $tipoDocumento = $this->tipoDocumentoRepository->listarTodas($request);
            return response()->json($tipoDocumento, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
