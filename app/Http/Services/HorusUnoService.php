<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class HorusUnoService
{

    private $client;
    public function __construct()
    {
    }

    /**
     * obtiene las historias de un afiliado
     * @param string $afiliado este es el documento del afiliado
     */
    public function getHistorias($afiliado)
    {
        try {
            $this->client = new Client(['verify' => false]);
            $response = $this->client->get('https://sumimedical.horus-health.com/api/historiapaciente/gethistoriaExterna?token=KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY&Num_Doc=' . $afiliado);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Obtiene la base64 para la impresión de la historia clínica.
     *
     * @param array $datos - Datos que se enviarán en la solicitud.
     * @return array - Respuesta decodificada de la API.
     * @throws \Exception - Si ocurre un error durante la solicitud.
     */
    public function getBase64($datos)
    {
        try {
            $this->client = new Client(['verify' => false]);

            // Verificamos que 'Tipocita_id' esté definido
            if (!isset($datos['Tipocita_id'])) {
                throw new \Exception("El índice 'Tipocita_id' no está definido en los datos proporcionados.");
            }

            // Definimos los IDs que corresponden a 'OcupacionalV2'
            $tiposOcupacionales = [13, 14, 15, 16];

            // Determinamos el 'type' basado en 'Tipocita_id'
            $type = in_array($datos['Tipocita_id'], $tiposOcupacionales) ? 'OcupacionalV2' : 'v2';

            // Si la API requiere una estructura diferente en 'data' para 'OcupacionalV2', ajustar aquí
            $dataEnvio = $datos;

            // Enviamos la solicitud
            $response = $this->client->request('POST', 'https://sumimedical.horus-health.com/api/historia/impresion-integracion', [
                'form_params' => [
                    'type' => $type,
                    'data' => $dataEnvio,
                ]
            ]);

            $body = $response->getBody()->getContents();
            $bodyDecode = json_decode($body, true);

            return $bodyDecode;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }



    /**
     * obtiene la base 64 para la impresion de adjuntos
     */
    public function getBase64Adjunto($datos)
    {
        try {
            $this->client = new Client(['verify' => false]);
            $response = $this->client->post('https://sumimedical.horus-health.com/api/historia/impresion-integracion-adjuntos', [
                'form_params' => [
                    'ruta' => $datos
                ]
            ]);
            $body = $response->getBody()->getContents();
            //$bodyDecode = json_decode($body, true);
            return $body;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
