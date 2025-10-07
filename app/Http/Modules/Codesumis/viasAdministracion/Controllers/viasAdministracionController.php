<?php

namespace App\Http\Modules\Codesumis\viasAdministracion\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\viasAdministracion\Requests\CrearviasAdministracionRequest;
use App\Http\Modules\Codesumis\viasAdministracion\Repositories\viasAdministracionRepository;
use App\Http\Modules\Codesumis\viasAdministracion\Requests\ActualizarViaAdministracionRequest;

class viasAdministracionController extends Controller
{
    private $viasRepository;

    public function __construct()
    {
        $this->viasRepository = new viasAdministracionRepository();
    }

    public function listar()
    {
        try {
            $vias = $this->viasRepository->listarVias(request());
            return response()->json($vias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearviasAdministracionRequest $request)
    {
        try {
            $this->viasRepository->crear($request->validated());
            return response()->json(['mensaje' => 'Se ha creado la via de administracion correctamente.'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error al crear la via de adiministracion' => $th->getMessage()], 400);
        }
    }

    public function actualizar(ActualizarViaAdministracionRequest $request, $id)
    {
        try {
            $this->viasRepository->actualizar($id, $request->validated());
            return response()->json(['mensaje' => 'Se ha actualizado la vía de administración correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error al actualizar la vía de administración' => $th->getMessage()], 400);
        }
    }

    public function eliminar($id)
    {
        try {
            $vias = $this->viasRepository->eliminar($id);
            return response()->json($vias);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
