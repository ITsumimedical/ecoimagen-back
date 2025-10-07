<?php

namespace App\Http\Modules\Bodegas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Bodegas\Repositories\BodegaRepository;
use App\Http\Modules\Bodegas\Requests\DetalleCodesumiReposicionRequest;
use App\Http\Modules\Bodegas\Requests\MinMaxRequest;
use App\Http\Modules\Bodegas\Services\BodegaService;
use App\Http\Modules\FacturaIncial\Repositories\FacturaInicialRepository;
use App\Http\Modules\MinMax\Models\MinMax;
use App\Http\Modules\TipoBodega\Repositories\TipoBodegaRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BodegaController extends Controller
{
    // private $bodegaRepository;

    // public function __construct(private FacturaInicialRepository $facturaInicialRepository,
    //                             private TipoBodegaRepository $tipoBodegaRepository,
    //                             private BodegaService $bodegaService)
    // {
    //     $this->bodegaRepository = new BodegaRepository;
    // }

    public function __construct(
        protected FacturaInicialRepository $facturaInicialRepository,
        protected TipoBodegaRepository $tipoBodegaRepository,
        protected BodegaService $bodegaService,
        protected BodegaRepository $bodegaRepository
    ) {}

    /**
     * lista las bodegas
     *
     * @return void
     */
    public function listar(Request $request){
        try {
            $bodegas = $this->bodegaRepository->listarBodega($request);
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function inventarioBodega(Request $request){
        try {
            $inventarioBodega = $this->bodegaRepository->inventarioBodega($request->all());
            return response()->json($inventarioBodega, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function guardarFactura(Request $request){
        try {
            $inventarioBodega = $this->facturaInicialRepository->guardarFactura($request->all());
            return response()->json($inventarioBodega, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        }

    public function articulosBodega(Request $request){
        try {
            $inventarioBodega = $this->bodegaRepository->articulosBodega($request->all());
            return response()->json($inventarioBodega, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarTipoBodega(Request $request){
        try {
            $bodegas = $this->tipoBodegaRepository->listar($request);
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
    public function crear(Request $request){
        try {
            $bodegas = $this->bodegaRepository->crear($request->all());
            return response()->json($bodegas, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $bodegas = $this->bodegaRepository->actualizarBodega($request->all(),$id);
            return response()->json([
                'mensaje' => 'Bodega actualizado con exito!.'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }

    public function listarCodesumi(Request $request){
        try {
            $codigo = $this->bodegaRepository->listarCodesumi($request->all());
            return response()->json($codigo, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function kardex(Request $request){
        try {
            $codigo = $this->bodegaRepository->kardex($request->all());
            return response()->json($codigo, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function minMax(MinMaxRequest $request){
        try {
            $codigo = $this->bodegaRepository->minMax($request->validated());
            return response()->json($codigo, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function exportar(Request $request){
        try {
            $codigo = $this->bodegaRepository->exportar($request->all());
            return $codigo;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function detallesCodesumisReposicion(DetalleCodesumiReposicionRequest $request){
        try {
            $codigo = $this->bodegaRepository->detallesCodesumisReposicion($request->validated());
            return response()->json($codigo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function usuarioDispensa(Request $request){
        try {
            $codigo = $this->bodegaRepository->usuarioDispensa($request->all());
            return $codigo;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function historicoDispensado(Request $request){
        try {
            $codigo = $this->bodegaRepository->historicoDispensado($request->all());
            return $codigo;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function historicoDispensadoDetalle(Request $request){
        try {
            $codigo = $this->bodegaRepository->historicoDispensadoDetalle($request->all());
            return $codigo;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizarEstado(Request $request, int $id)
    {
        try {
            $bodegas = $this->bodegaRepository->actualizarEstado($request->all(),$id);
            return response()->json([
                'mensaje' => 'Bodega actualizado con exito!.'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }

    public function agregarPersonal(Request $request)
    {
        try {
            $bodegas = $this->bodegaRepository->agregarPersonal($request->all());
            return response()->json([
                'mensaje' => 'Bodega actualizado con exito!.'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }

    public function listarBodegasUsuario(){
        try {
            $bodegas = Bodega::where('estado_id',1)->get();
//                $this->bodegaRepository->listarBodegasUsuario();
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Listar todas las bodegas
     *
     * Este método utiliza el servicio de bodega para obtener todas las bodegas
     * y devuelve la información en formato JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable Si ocurre algún error durante la ejecución
     *
     * @version 1.0.0
     * @since 2024-07-30
     *
     * @example
     * // Ejemplo de uso:
     * // Enviar una solicitud GET a la ruta correspondiente para obtener todas las bodegas:
     * // GET /api/bodegas
     *
     * @author
     *  - kobatime
     */
    public function listarTodasBodegas(){
        try {
            $bodegas = $this->bodegaService->listarTodasBodegas();
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al mostar las bodegas'
            ], 400);
        }
    }

    public function buscarBodega(int $bodega_id){
        try {
            $bodegas = $this->bodegaService->buscarUnaBodega($bodega_id);
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al mostar la informacion de la bodega'
            ], 400);
        }
    }

    public function getUsuariosBodega(int $bodega_id){
        try {
            $bodegas = $this->bodegaService->buscarUsuariosBodega($bodega_id);
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al mostar la informacion de la bodega'
            ], 400);
        }
    }

    public function eliminarUsuarioBodega(Request $request)
    {
        $bodegaId = $request->input('bodega_id');
        $userId = $request->input('user_id');

        if (is_null($bodegaId)) {
            return response()->json(['error' => 'El ID de la bodega es requerido'], 400);
        }

        try {
            $resultado = $this->bodegaService->eliminarUserBodega($bodegaId, $userId);
            if ($resultado) {
                return response()->json(['message' => 'Usuario eliminados correctamente'], 200);
            } else {
                return response()->json(['error' => 'No se pudo eliminar los usuarios de la bodega'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listarBodegasAsociadas(){
        try {
        $bodegas= $this->bodegaRepository->listarBodegasUsuario();
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], 400);
        }
    }

    public function listarPorEstado(Request $request, $estado_id = 1){
        try {
            $bodegas = $this->bodegaRepository->listarPorEstado($estado_id);
            return response()->json($bodegas,200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las bodegas por estado'
            ], 400);
        }
    }

    /**
     * Funcion para obtener los datos dispensados movimientos
     * @author Sofia
     */
    public function historicoDispensadoMovimientos(Request $request){
        try {
            $movimiento = $this->bodegaRepository->HistoricoOrdenesDispensadas($request->all());
            return response()->json($movimiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para obtener los detalles de cada movimiento despensado
     * @author Sofia
     */
    public function historicoOrdenArticulosDispensadosPorOrden($orden_id){
        try {
            $movimientoDetalle = $this->bodegaRepository->HistoricoOrdenArticulosDispensados($orden_id);
            return response()->json($movimientoDetalle, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoMovimientosPorOrdenArticulo($orden_articulo_id){
        try {
            $movimientos = $this->bodegaRepository->historicoMovimientosPorOrdenArticulo($orden_articulo_id);
            return response()->json($movimientos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorHistoricoOrdenesDispensadas(Request $request)
    {
        try {
            $contador = $this->bodegaRepository->ContadorHistoricoOrdenes($request->all());
            return response()->json($contador);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarBodegasAsociadasPorEntidad(int $entidad_id)
    {
        try {
            $bodegas = $this->bodegaRepository->listarBodegasUsuarioPorEntidad($entidad_id);
            return response()->json($bodegas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
