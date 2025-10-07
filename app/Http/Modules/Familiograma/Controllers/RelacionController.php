<?php

namespace App\Http\Modules\Familiograma\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Familiograma\Repositories\RelacionRepository;
use App\Http\Modules\Familiograma\Services\RelacionService;
use Illuminate\Http\Request;

class RelacionController extends Controller
{
    public function __construct(
        private RelacionRepository $relacionRepository,
        private RelacionService $relacionService,
    ) {}

    public function crearRelacion(Request $request)
    {
        return response()->json($this->relacionService->crearRelacion($request));
    }
}
