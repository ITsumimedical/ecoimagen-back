<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Services;
use Illuminate\Support\Facades\Http;

class MesaAyudaMedicinaIntegralService
{

    private $url_base;

    public function __construct(
    ) {
        $this->url_base = config('services.medicina_integral.api_url');
    }

    public function getDatos(string $token)
    {
        return Http::withOptions([
            'verify' => false,
        ])
            ->withToken($token)
            ->get($this->url_base . '/api/interoperabilidad-mesa-ayuda/listar-mesa-ayuda-medicina-integral')
            ->json();
    }

}

