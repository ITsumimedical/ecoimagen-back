<?php

namespace App\Http\Modules\CategoriaHistorias\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\CategoriaHistorias\Models\TipoCategoriaHistoria;
use App\Http\Modules\CategoriaHistorias\Repositories\CategoriaHistoriaRepository;
use App\Http\Modules\CategoriaHistorias\Requests\ActualizarCategoriaHistoriaRequest;
use App\Http\Modules\CategoriaHistorias\Requests\CrearCategoriaHistoriaRequest;
use App\Http\Modules\CategoriaHistorias\Services\CategoriaHistoriaServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaHistoriaController extends Controller
{
    private $categoriHistoriarepository;
    protected $categoriaHistoriaService;

    public function __construct(CategoriaHistoriaRepository $categoriaHistoriaRepository, CategoriaHistoriaServices $categoriaHistoriaService ) {
        $this->categoriHistoriarepository = $categoriaHistoriaRepository;
        $this->categoriaHistoriaService = $categoriaHistoriaService;
    }


    /**
     * lista las categorias de historia
     * @param Request $request
     * @return Response $categoriaHistoria
     * @author JDSS
     */
    public function listar(Request $request)
    {
        try {
            $categoriaHistoria = $this->categoriHistoriarepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $categoriaHistoria
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las categorias de historia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una categoria de historia
     * @param Request $request
     * @return Response $categoriaHistoria
     * @author JDSS
     */
    public function crear(CrearCategoriaHistoriaRequest $request): JsonResponse
    {
        try {
            $nuevaCategoriaHistoria = new CategoriaHistoria($request->all());
            $categoriaHistoria = $this->categoriHistoriarepository->guardarCategoria($nuevaCategoriaHistoria);
            return response()->json([
                'res' => true,
                'data' => $categoriaHistoria,
                'mensaje' => 'Categoria historia creada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la categoria de historia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una categoria de histria
     * @param Request $request
     * @param int $id
     * @return Response $actualizarCategoriaHistoria
     * @author JDSS
     */
    public function actualizar(ActualizarCategoriaHistoriaRequest $request, int $id): JsonResponse
    {
        try {
            $actualizarCategoriaHistoria = $this->categoriaHistoriaService->actualizarCategoria($request, $id);
            return response()->json([
                'res' => true,
                $actualizarCategoriaHistoria,
                'mensaje' => 'La categoria de historia fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'res' => false,
                'mensaje' => 'Error al intentar actualizar la categoria de historia!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function tipoCategoriaHistorias(){
        $tipoCategorias = TipoCategoriaHistoria::all();
        return response()->json($tipoCategorias);
    }
}
