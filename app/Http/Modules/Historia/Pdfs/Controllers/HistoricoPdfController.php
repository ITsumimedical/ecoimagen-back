<?php

namespace App\Http\Modules\Historia\Pdfs\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\Pdfs\Repositories\HistoricoPdfRepository;
use App\Http\Modules\Historia\Pdfs\Requests\SubirPdfRequest;
use App\Http\Modules\Historia\Pdfs\Services\HistoricoPdfService;
use App\Http\Modules\Historia\Services\HistoricoService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class HistoricoPdfController extends Controller
{

    public function __construct(
        private HistoricoPdfRepository  $pdfRepository,
        private HistoricoPdfService $pdfService
    ){}

    /**
     * Obtiene los pdfs de un afiliado
     * @author Manuela
     * @param string $numero de documento
     * @return pdfs con datos del afiliado
     */
    public function buscarPorDocumento(string $documento)
    {
        try {
            dd($documento);
            $pdfs = $this->pdfRepository->buscarPorDocumento($documento);
            return response()->json(['pdfs' => $pdfs], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se puede obtener la caracterización del afiliado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Crea una encuesta
     * @author Manuela
     * @param array $data
     * @return subePdf
     */

    public function subePdf(SubirPdfRequest $request)
    {
        try {

            $url = $this->pdfService->subirPDF($request->file('pdf')->validate());

            return response()->json([
                'success' => true,
                'mensaje' => 'PDF subido correctamente',
                'data' => $url,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No se pudo subir el PDF',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
