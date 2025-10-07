<?php

namespace App\Http\Modules\Adjuntos\Controller;

use App\Http\Modules\Adjuntos\Requests\ArchivoDigitalRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdjuntoController extends Controller
{
    public function get(Request $request)
    {
        return Storage::disk('server37')->get($request->ruta);
    }

    public function getType(Request $request)
    {

        $path = pathinfo(Storage::disk('server37')->path($request->ruta));

        switch ($path['extension']) {
            case 'pdf':
                $extension = "application/pdf";
                break;
            case 'csv':
            case 'xls':
                $extension = "application/vnd.ms-excel";
                break;
            case 'jpeg':
            case 'jpg':
                $extension = "image/jpeg";
                break;
            case 'doc':
            case 'docx':
                $extension = "application/msword";
                break;
            case 'png':
            case 'PNG':
                $extension = "image/png";
                break;
            case 'xlsx':
                $extension = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8";
                break;
            case 'txt':
            case 'TXT':
                $extension = "text/plain";
                break;
            case 'odt':
                $extension = "application/vnd.oasis.opendocument.text";
                break;
            default:
                $extension = "application/octet-stream";
                break;
        }

        return response()->json($extension, 200);
    }

    /**
     * Crea una url temporal para descargar un archivo
     * @param ArchivoDigitalRequest $request
     * @return string
     * @author Thomas
     */
    public function generarUrlTemporalDescargarArchivo(Request $request): string
    {
        // dd('perra', $request['nombre_archivo'][0]);
        $disco = $request['disco'] ?? 'server37';
        $tiempo = $request['tiempo'] ?? 10;

        if (is_array($request['nombre_archivo']) && isset($request['nombre_archivo'][0])) {
            $nombreArchivo = $request['nombre_archivo'][0];
        } else {
            $nombreArchivo = $request['nombre_archivo'];
        }

        $fullPath = $nombreArchivo;

        return Storage::disk($disco)->temporaryUrl(
            $fullPath,
            now()->addMinutes($tiempo)
        );
    }
}
