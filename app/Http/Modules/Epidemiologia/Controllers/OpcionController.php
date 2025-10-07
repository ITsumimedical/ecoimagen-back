<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\OpcionRepository;
use App\Http\Modules\Epidemiologia\Requests\OpcionRequest;
use App\Http\Modules\Epidemiologia\Services\OpcionService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class OpcionController extends Controller
{
    public function __construct(private OpcionService $opcionService, private OpcionRepository $opcionRepository) {}

    /**
     * Funcion para listar las opciones de los campos de la ficha  epidemiologica
     * @author Sofia O
     */
    public function listarOpciones(Request $request)
    {
        try {
            $listar = $this->opcionService->listarOpciones($request->all());
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al listar las opciones'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para crear la opcion del campo de la ficha epidemiologica
     * @author Sofia O
     */
    public function crearOpciones(OpcionRequest $request)
    {
        try {
            $crear = $this->opcionRepository->crearOpcion($request->validated());
            return response()->json($crear, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Hubo un error al crear las opciones'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actulizar la opcion de la ficha epidemiologica
     * @author Sofia O
     */
    public function actualizarOpciones(OpcionRequest $request, $id)
    {
        try {
            $actualizarOpcion = $this->opcionService->actualizarOpcion($request->validated(), $id);
            return response()->json($actualizarOpcion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al actualizar el evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para cambiar el estado del opcion
     * @author Sofia O
     */
    public function cambiarEstadoOpcion($id)
    {
        try {
            $cambiarEstado = $this->opcionService->actualizarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al cambiar el estado del evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para listar las opciones segun el evento
     * @author Sofia O
     */
    public function listarOpcionesPorEvento(Request $request)
    {
        try {
            $listar = $this->opcionRepository->buscarOpcionesPorEventoId($request->all());
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Hubo un erro al listar las opciones por evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
