<?php

namespace App\Http\Modules\Rips\Repositories;

use App\Http\Modules\Rips\Af\Models\Af;
use App\Http\Modules\Rips\Models\Adjuntorip;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaqueteRipRepository
{
    public function __construct(
        protected PaqueteRip $paqueteRip,
        protected Af $af,
    ) {}

    public function certificadoRips($request)
    {
        $paqueteRip = $this->paqueteRip->with('rep', 'afs', 'rep.prestadores')->where('id', $request['id'])->first();
        $total = $this->af->select([DB::raw('SUM(valor_Neto::numeric) as total')])->where('paquete_rip_id', $paqueteRip->id)->first();

        $type = $request['tipoRip'];

        return (object)[
            'paqueteRip' => $paqueteRip,
            'total' => $total,
            'type' => $type,
        ];
    }

    // function consultarNombreSoporte($adjuntoId)
    // {
    //     $path = '/rips/sumimedical/' . $adjuntoId;
    //     $archivos = Storage::disk('server37')->allFiles($path);
    //     // Filtrar los archivos PDF y reindexar el array para que no sea asociativo
    //     $pdfs = array_values(array_filter($archivos, function ($archivo) {
    //         $info = pathinfo($archivo);
    //         return isset($info['extension']) && strtolower($info['extension']) === 'pdf';
    //     }));

    //     return $pdfs;
    // }
    function consultarNombreSoporte($adjuntoId, $numeroFactura = null)
    {
        $path = '/rips/sumimedical/' . $adjuntoId;
        $archivos = Storage::disk('server37')->allFiles($path);

        // Filtrar los archivos PDF
        $pdfs = array_values(array_filter($archivos, function ($archivo) {
            $info = pathinfo($archivo);
            return isset($info['extension']) && strtolower($info['extension']) === 'pdf';
        }));

        // Si se proporciona el número de factura, buscar el archivo que lo contenga en el nombre
        if ($numeroFactura) {
            $pdfFiltrado = array_filter($pdfs, function ($archivo) use ($numeroFactura) {
                return str_contains($archivo, $numeroFactura);
            });

            // Reindexar y devolver solo ese archivo (o archivos si hay más de uno que coincida)
            return array_values($pdfFiltrado);
        }

        // Si no se proporciona número de factura, retornar todos los PDFs
        return $pdfs;
    }

    function descargarSoportesJson($adjuntoId, $numeroFactura = null, $ruta = null)
    {
        $path = $ruta;

        if (!Storage::disk('server37')->exists($path)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $contenido = Storage::disk('server37')->get($path);
        $base64 = base64_encode($contenido);
        $nombreArchivo = basename($path);
        return [
            'nombreArchivo' => $nombreArchivo,
            'contenidoBase64' => $base64,
        ];
    }
}
