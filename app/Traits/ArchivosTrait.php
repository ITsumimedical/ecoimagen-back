<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

trait ArchivosTrait
{

    public function obtenerNombreArchivo($archivo)
    {
        return $archivo->getClientOriginalName();

    }

    public function borrarArchivo($archivo, $disco = 'server37')
    {
        return Storage::disk($disco)->delete($archivo);
    }

    public function moverArchivo($archivo1, $archivo2)
    {
        return Storage::move($archivo1, $archivo2);
    }

    public function subirArchivoNombre($ruta, $archivo, $nombre, $disco)
    {
        Storage::disk($disco)->putFileAs($ruta, $archivo, $nombre);
        $rutaCompleta = '/' . $ruta . '/' . $nombre;
        return $rutaCompleta;
    }

    /**
     * genera un excel y retorna el buffer
     * @param array $data
     * @param array $headers
     * @author David Peláez
     */
    public function generarExcel(array $data, $headers = [])
    {
        return (new FastExcel($data))->export('errores.xlsx');
    }

    /**
     * Genera un excel y lo retorna en base 64
     * @param array $data
     * @param array $headers
     * @author David Peláez
     */
    public function generarExcelBase64(array $data, $headers = [])
    {
        return $this->convertirArchivoBase64($this->generarExcel($data, $headers));
    }

    /**
     * convierte un archivo en base64
     * @param $file
     * @return string
     * @author David Peláez
     */
    public function convertirArchivoBase64($file)
    {
        return base64_encode(file_get_contents($file));
    }

    // public function subirArchivoNombre($ruta, $archivo, $nombre, $disco)
    // {
    //     return  Storage::put($ruta, $archivo, $nombre);
    // }

    /**
     * Genera una url temporal para subir un archivo
     * @param string $fileName
     * @param string $path
     * @param string $disco
     * @param int $tiempo
     * @return array
     * @author Thomas
     */
    public function generarUrlTemporalSubirArchivo(string $fileName, string $path = "temp", string $disco = 'digital', int $tiempo = 10): array
    {
        $filePath = "$path/$fileName";
        return Storage::disk($disco)->temporaryUploadUrl(
            $filePath,
            now()->addMinutes($tiempo)
        );
    }
    /**
     * 
     * elimina una carpeta de forma nativa
     */
    public function deleteFolder($folderPath)
    {
        foreach (glob($folderPath . '/*') as $file) {
            is_dir($file) ? $this->deleteFolder($file) : unlink($file);
        }
        rmdir($folderPath);
    }

    /**
     * genera una url dinamica
     * @param string $ruta
     * @param Carbon $tiempo
     * @author David Peláez
     */
    public function generarUrlTemporal(string $ruta, Carbon $tiempo, string $disk = 'digital'){
        return Storage::disk('digital')->temporaryUrl($ruta, $tiempo);
    }
}
