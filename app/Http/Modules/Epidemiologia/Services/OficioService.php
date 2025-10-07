<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Repositories\OficioRepository;

class OficioService
{
    public function __construct(private OficioRepository $oficioRepository)
    {}
}
