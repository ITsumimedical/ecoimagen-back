<?php

namespace App\Http\Services;

use Error;
use ZipArchive;

class ZipService {

    
    public function __construct(){}

    public function crear($rutaCarpeta, $nombre_zip) {
        # creamos la instancia del zip
        $zip = new ZipArchive();
        $zipRuta = storage_path('app/tmp/' . $nombre_zip);
    
        // Asegurar que la carpeta de destino existe
        if (!file_exists(dirname($zipRuta))) {
            mkdir(dirname($zipRuta), 0755, true);
        }
    
        // Si el archivo ZIP ya existe, eliminarlo
        if (file_exists($zipRuta)) {
            unlink($zipRuta);
        }
    
        if ($zip->open($zipRuta, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new Error('Error al intentar crear el archivo zip', 500);
        }
    
        $this->agregarCarpeta($rutaCarpeta, $zip);
        $zip->close();
    
        return $zipRuta;
    }

    /**
     * 
     */
    private function agregarCarpeta($carpeta, $zip, $carpetaPadre = '')
    {
        # Abrir la carpeta
        $archivos = scandir($carpeta);

        # Recorrer todos los archivos y carpetas
        foreach ($archivos as $archivo) {

            if ($archivo != '.' && $archivo != '..') {
                $rutaArchivo = $carpeta . '/' . $archivo;
                $relativePath = $carpetaPadre ? $carpetaPadre . '/' . $archivo : $archivo;

                // Si es una carpeta, llamamos a la función recursivamente
                if (is_dir($rutaArchivo)) {
                    # Añadimos la carpeta al ZIP
                    $zip->addEmptyDir($relativePath);
                    $this->agregarCarpeta($rutaArchivo, $zip, $relativePath);
                } else {
                    # Si es un archivo, lo agregamos al ZIP
                    $zip->addFile($rutaArchivo, $relativePath);
                }
            }
        }
    }

}