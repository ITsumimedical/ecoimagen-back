<?php

namespace App\Http\Modules\OrganosFonoarticulatorios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\OrganosFonoarticulatorios\Requests\CrearOrganoFonoarticulatorioRequest;
use App\Http\Modules\OrganosFonoarticulatorios\Services\OrganosFonoarticulatoriosService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganosFonoarticulatoriosController extends Controller
{
    public function __construct(private OrganosFonoarticulatoriosService $organosFonoarticulatoriosService)
    {}

    public function crear(CrearOrganoFonoarticulatorioRequest $request)
    {
        try {
            $organosFonoarticulatorio = $this->organosFonoarticulatoriosService->CrearOrganoFonoarticulatorio($request->validated());
            return response()->json($organosFonoarticulatorio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al Crear'
            ], 500);
        }
    }
}
