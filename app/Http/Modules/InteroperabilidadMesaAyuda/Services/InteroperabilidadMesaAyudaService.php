<?php

namespace App\Http\Modules\InteroperabilidadMesaAyuda\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InteroperabilidadMesaAyudaService extends Controller
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

    private function login()
    {
        return Cache::remember('token_medicina_integral', 31536000, function () {
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
            Log::info($response->body());
            throw new \Exception("Error al obtener token de Medicina Integral: " . $response->body());
        });
    }

    public function getDatos(array $request)
    {
        return Http::withToken($this->login())->get(
            $this->url_base . "/interoperabilidad-mesa-ayuda/listar-mesa-ayuda-medicina-integral",
            [
                'page' => $request['page'] ?? 1,
                'cantidad' => $request['cantidad'] ?? 10,
                'estado_filtro' => $request['estado_filtro'] ?? null,
                'radicado_filtro' => $request['radicado_filtro'] ?? null,
                'sede_filtro' => $request['sede_filtro'] ?? null,
                'fechaFiltro' => $request['fechaFiltro'] ?? null,
            ]
        )->json();
    }
}
