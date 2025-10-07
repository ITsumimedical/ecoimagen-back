<?php

namespace App\Http\Modules\Ecomapa\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Ecomapa\Repositories\RelacionEcomapaRepository;
use App\Http\Modules\Ecomapa\Request\RelacionEcomapaRequest;
use App\Http\Modules\Ecomapa\Services\RelacionEcomapaService;
use Illuminate\Http\Request;

class RelacionEcomapaController extends Controller
{
    public function __construct(
        private RelacionEcomapaRepository $relacionRepository,
        private RelacionEcomapaService $relacionService,
    ) {}

    public function crearRelacion(RelacionEcomapaRequest $request)
    {
        try {
            $resultado = $this->relacionService->crearRelacion($request->validated());

            return response('Relaciones creadas exitosamente', 201);
        } catch (\Exception $e) {
            return response('Error al crear relaciones: ' . $e->getMessage(), 500);
        }
    }
}
