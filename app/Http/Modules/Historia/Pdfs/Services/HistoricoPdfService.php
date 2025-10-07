<?php

namespace App\Http\Modules\Historia\Pdfs\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;



class HistoricoPdfService
{

    public function subirPDF($file)
    {
        $tipoDocumento = 'CC';
        $numeroDocumento = '1';
        $fecha = date('Y-m-d');
        $especialidad = 'Cardiologia';
        $nombreArchivo = "{$tipoDocumento}_{$numeroDocumento}_{$fecha}_{$especialidad}.pdf";

        $ruta = 'historiasDinamica/' . $nombreArchivo;

        $subido = Storage::disk('server37')->put($ruta, file_get_contents($file), 'public');

        if (!$subido) {
            throw new \Exception("No se pudo subir el PDF");
        }

        return Storage::disk('server37')->url($ruta);
    }

}




