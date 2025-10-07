<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Services;

use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use Illuminate\Support\Facades\Http;

class MesaAyudaFomagService
{

    private $url_base;

    public function __construct(
        private FomagHttp $fomagHttp,
    ) {
        $this->url_base = config('services.fomag.api_url');
    }




}
