<?php

namespace  App\Http\Modules\PDF\Services;

use App\Formats\Prefactura;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PdfService
{
    public function __construct(
        protected OrdenProcedimientoRepository $ordenProcedimientoRepository,
        protected OrdenArticuloRepository $ordenArticuloRepository
    ) {}

    public function formatoNegacion($pdf, $request)
    {
        $tipo_orden = $request->tipoOrden;

        if ($tipo_orden === 'Servicio') {
            foreach ($request['orden_procedimiento'] as $procedimiento) {
                $ordenProcedimiento = $this->ordenProcedimientoRepository->formatoNegacion($tipo_orden, $procedimiento);
                $pdf->generar($tipo_orden, $ordenProcedimiento);
            }
        } elseif ($tipo_orden === 'Medicamento') {
            foreach ($request['orden_articulo'] as $articulo) {
                $ordenArticulo = $this->ordenArticuloRepository->formatoNegacion($articulo);
                $pdf->generar($tipo_orden, $ordenArticulo);
            }
        }

        $pdf->AddPage();
        $pdf->body();
        $pdf->Output('I', 'formatos_negacion.pdf');
    }

    /**
     * une x pdfs en uno solo
     * @param array $rutasArchivos
     * @param string $rutaSalida
     * @param string $outputType
     * @return void
     * @author David Peláez
     */
    public function combinarPDFs(array $rutasArchivos, string $rutaSalida, string $outputType = 'F')
    {
        # creamos la instancia del fpdi
        $pdf = new Fpdi();
        foreach ($rutasArchivos as $ruta) {
            $paginas = $pdf->setSourceFile($ruta);
            # el paso se hace pagina por pagina
            for ($i = 1; $i <= $paginas; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }
        }
        $pdf->Output($outputType, $rutaSalida); // Guarda el archivo en el servidor
    }

    /**
     * Une documentos pdf y regresa el lugar de almacenamiento del documento final
     * @param array $archivos
     * @return string
     */
    public function unirPdf(array $archivos)
    {
        $rutas = [];
        $eliminar = [];

        #se crea la ruta de almacenamiento de los archivos
        $ruta = storage_path('app/tempdf');

        #se crea la ruta de salida de los archivos
        $rutaSalida = storage_path('app/tempdf'.uniqid().'.pdf');


        #se crea el directorio si no existe
        if(!file_exists($ruta)){
            mkdir($ruta,0777,true);
        }

        foreach($archivos['documentos'] as $archivo){

            #se crea el nombre del archivo
            $nombreArchivo = uniqid().'.pdf';

            #creo la ruta del archivo
            $rutaArchivo = $ruta . '/' . $nombreArchivo;

            #guardo el archivo
            file_put_contents($rutaArchivo,file_get_contents($archivo));

            #almaceno la ruta del archivo
            array_push($rutas,$rutaArchivo);

            array_push($eliminar,'tempdf/'.$nombreArchivo);

        }

        #se procesan y se unen los pdf's al final
        $this->combinarPDFs($rutas,$rutaSalida);

        #obtengo el archivo y lo regreso
        $archivo = file_get_contents($rutaSalida);

        #elimino los archivos de la carpeta temporal
        Storage::delete($eliminar);

        return $rutaSalida;
    }

    public function imprimirPrefacturaElectronica($request)
    {
        $pdf = new Prefactura();
        return $pdf->generar($request);
    }
}
