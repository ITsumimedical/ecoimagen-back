<?php

namespace App\Http\Modules\Certificados\Controllers;

use App\Formats\CertificadoAfiliado;
use App\Formats\CertificadoAfiliadoFerrocarriles;
use App\Formats\CertificadoFamiliarAfiliado;
use App\Jobs\CertificadosMasivos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Certificados\Requests\CrearCertificadoRequest;
use App\Http\Modules\Certificados\Repositories\CertificadoRepository;

class CertificadoController extends Controller
{
    public function __construct(private CertificadoRepository $certificadoRepository) {}


    public function crear(CrearCertificadoRequest $request)
    {
        try {
            $certificado = $this->certificadoRepository->crear($request->validated());

            $pdf = new CertificadoAfiliado();
            return $pdf->generar($certificado->numero_documento);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function pdf(Request $request)
    {
        $pdf = new CertificadoAfiliado();
        return $pdf->generar($request->id);
    }

    public function certificadoAfiliadoFerro(Request $request)
    {
        $pdf = new CertificadoAfiliadoFerrocarriles();
        return $pdf->generar($request->id);
    }
    public function certificadoFamiliarFerro(Request $request)
    {
        $pdf = new CertificadoFamiliarAfiliado();
        return $pdf->generar($request->id);
    }

    public function CertificadosMasivos(Request $request)
    {
        CertificadosMasivos::dispatch($request->all())->onQueue('CertificadosMasivos');
    }
}
