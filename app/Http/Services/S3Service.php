<?php 

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class S3Service
{
    public function __construct()
    {
    }

    /**
     * Obtiene las historias clínicas asociadas al número de documento de un afiliado.
     *
     * @param string $documento Número de documento del afiliado
     * @param string $carpeta Nombre de la carpeta donde se buscarán los archivos
     * @return array Retorna un arreglo con las rutas de los archivos que contienen el documento en su nombre
     * @throws \Exception Lanza una excepción si ocurre algún error durante la ejecución
     * @author Kobatime
     **/
    public function getHistorias($documento, $carpeta)
    {
        try {
            // Obtiene todos los archivos dentro de la carpeta especificada en el disco 'server37'
            // Esto incluye archivos dentro de subcarpetas, si las hay
            $archivos = Storage::disk('server37')->allFiles($carpeta);
            $archivosEncontrados = [];
            foreach ($archivos as $archivo) {
                if (str_contains($archivo, $documento)) {
                    // Si hay coincidencia, se agrega el archivo al arreglo de resultados
                    $archivosEncontrados[] = $archivo;
                }
            }

            // Retorna el arreglo con las coincidencias encontradas (puede estar vacío)
            return $archivosEncontrados;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }


}