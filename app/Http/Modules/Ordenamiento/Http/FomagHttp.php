<?php

namespace App\Http\Modules\Ordenamiento\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FomagHttp
{

    private $client_id;
    private $client_secret;
    private $url_base;

    public function __construct()
    {
        $this->client_id = config('services.fomag.client_id');
        $this->client_secret = config('services.fomag.client_secret');
        $this->url_base = config('services.fomag.api_url');
    }

    /**
     * inicia sesion como cliente en fomag
     * @return string
     * @author David Peláez
     */
    private function login()
    {
        return Cache::remember('token_fomag', 31536000, function () {
            $response = Http::withOptions([
                'verify' => false, // Deshabilita la verificación SSL
            ])->post("$this->url_base/auth/login-client/token", [
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }
        });
    }

    /**
     * envia una orden a fomag
     * @param array $json
     * @return Response
     * @author David Peláez
     */
    public function enviarOrden(array $json)
    {
        $response = Http::withOptions([
            'verify' => false, // Deshabilita la verificación SSL
        ])
            ->withToken($this->login())
            ->post("$this->url_base/v1/ordenamiento/transcribir", $json);

        if ($response->status() === 401) {
            Cache::forget('token_fomag');
            return $this->enviarOrden($json);
        }

        return $response;
    }

    /**
     * enviar notificacion de despacho
     * @param array $json
     * @return Response
     * @author David Peláez
     */
    public function enviarNotificacionDespacho(array $json)
    {
        $response = Http::withOptions([
            'verify' => false, // Deshabilita la verificación SSL
        ])
            ->withToken($this->login())
            ->post("$this->url_base/v1/medicamentos/notificacion-despacho", $json);

        if ($response->status() === 401) {
            Cache::forget('token_fomag');
            return $this->enviarNotificacionDespacho($json);
        }

        return $response;
    }


    public function getDatos(array $data)
    {
        return Http::withToken($this->login())->get(
            $this->url_base . "/interoperabilidad-mesa-ayuda/listar-mesa-ayuda-fomag",
            [
                'page' => $data['page'] ?? 1,
                'cantidad' => $data['cantidad'] ?? 10,
                'estado_filtro' => $data['estado_filtro'] ?? null,
                'radicado_filtro' => $data['radicado_filtro'] ?? null,
                'fechaFiltro' => $data['fechaFiltro'] ?? null,
                'sede_filtro' => $data['sede_filtro'] ?? null,
            ]
        )->json();
    }


    public function categoriasFomag(array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->get("$this->url_base/interoperabilidad-mesa-ayuda/categorias-mesa-ayuda", $data);
        return $response->json();
    }

    public function reasignarMesaAyudaFomag(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/gestionar-reasignacion/$id", $data);
        return $response->json();
    }

    public function comentarioMesaAyudaFomag(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/comentario-mesa-ayuda/$id", $data);
        return $response->json();
    }


    // FUNCION ECHA PARA LISTAR EN EL MODAL LOS COMENTARIOS Y GESTIONES DE LA INTEROPERABILIDAD

    public function listarComentariosMesaAyudaFomag(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->get("$this->url_base/interoperabilidad-mesa-ayuda/listar-comentarios-mesa-ayuda-fomag/$id", $data);
        return $response->json();
    }

    // FUNCION PARA DAR SOLUCION AL CASO PENDIENTE DE LA INTEROPERABILIDAD DE FOMAG

    public function solucionarMesaAyudaFomag(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/solucionar-mesa-ayuda/$id", $data);
        return $response->json();
    }

    public function consultarAdjuntosFomag(int $id)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/consultar-adjuntos-mesa-ayuda/$id");

        return $response->json();
    }

    /**
     * se envia la historia clinica a fomag una vez validada
     * @param int $ordenId
     * @param string $ruta
     * @return $response
     * @author jose vasquez
     */
    public function enviarHistoriaFomag(int $ordenId, string $ruta)
    {

        if (!file_exists($ruta)) {
            return false;
        }

        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->attach(
                'historia',
                file_get_contents($ruta),
                "historia-orden-{$ordenId}.pdf"
            )
            ->post("$this->url_base/v1/ordenamiento/historias-adjunto", [
                'orden_id' => $ordenId,
            ]);

        return $response;
    }
}
