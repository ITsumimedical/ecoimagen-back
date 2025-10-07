<?php

namespace App\Http\Modules\Historia\Pdfs\Repositories;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HistoricoPdfRepository
{

    /**
     * Obtiene los pdfs de un afiliado
     * @author Manuela
     * @param string $numero de documento
     * @return pdfs con datos del afiliado
     */

    public function buscarPorDocumento(string $numeroDocumento)
    {
        $bucketUrl = env('DO_URL');
        $path = 'historiasDinamica';
        $archivos = Storage::disk('spaces')->files("repositoriopruebashorus/{$path}");

        $pdfs = collect($archivos)
            ->filter(function ($archivo) use ($numeroDocumento) {
                return Str::contains(basename($archivo), $numeroDocumento);
            })
            ->map(function ($archivo) use ($bucketUrl) {
                $nombre = basename($archivo);
                $partes = explode('_', $nombre);
                $fecha = isset($partes[2]) ? substr($partes[2], 0, 10) : null;
                return [
                    'nombre'         => $nombre,
                    'url'            => "{$bucketUrl}/{$archivo}",
                    'fecha_creacion' => $fecha,
                ];
            })
            ->values();

        return $pdfs;
    }
}


