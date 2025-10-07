<?php

namespace App\Http\Modules\InteroperabilidadMesaAyuda\Http;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedicinaIntegralHttp
{
    private $client_id;
    private $client_secret;
    private $url_base;

    public function __construct()
    {
        $this->client_id = config('services.medicina_integral.client_id');
        $this->client_secret = config('services.medicina_integral.client_secret');
        $this->url_base = config('services.medicina_integral.api_url');
    }

    /**
     * inicia sesion como cliente en fomag
     * @return string
     * @author Alejandro Ocampo
     */

    private function login()
    {
        return Cache::remember('token_medicina_integral', 31536000, function () {
            $response = Http::withOptions([
                'verify' => false,
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


    public function listarCategoriasMedicinaIntegral(array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->get("$this->url_base/interoperabilidad-mesa-ayuda/listar-categorias-mesa-ayuda-medicina_integral", $data);
        return $response->json();
    }


    public function reasignarMesaAyudaMedicinaIntegral(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/reasignar-mesa-ayuda-medicina-integral-interoperabilidad/$id", $data);
        return $response->json();
    }

    public function comentarioMesaAyudaMedicinaIntegralInteroperabilidad(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/comentario-mesa-ayuda-medicina-integral-interoperabilidad/$id", $data);
        return $response->json();
    }

    public function listarComentariosMesaAyudaMedicinaIntegral(int $id, array $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->get("$this->url_base/interoperabilidad-mesa-ayuda/listar-comentario-mesa-ayuda-medicina-integral-interoperabilidad/$id", $data);
        return $response->json();
    }

    public function solucionarMesaAyudaMedicinaIntegral(int $id, array $data)
    {
         $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/solucionar-mesa-ayuda-medicina-integral-interoperabilidad/$id", $data);
        return $response->json();
    }

    public function consultarAdjuntosMedicinaIntegral(int $id)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])
            ->withToken($this->login())
            ->post("$this->url_base/interoperabilidad-mesa-ayuda/adjuntos-mesa-ayuda-medicina-integral-interoperabilidad/$id",);
        return $response->json();
    }
}
