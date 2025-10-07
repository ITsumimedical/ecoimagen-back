<?php

namespace App\Http\Modules\Medicamentos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Modules\Medicamentos\services\MedicamentoService;
use App\Http\Modules\Medicamentos\Repositories\MedicamentoRepository;
use App\Http\Modules\Medicamentos\Requests\DescargarAutorizacionFomagRequest;

class MedicamentoController extends Controller
{

    public function __construct(private MedicamentoRepository $medicamentoRepository, private MedicamentoService $medicamentoService) {}

    public function listarVademecum(Request $request)
    {
        $medicamnetos = $this->medicamentoRepository->listar($request);
        return response()->json($medicamnetos);
    }

    public function listarMedicamentoOrdenamiento(Request $request)
    {
        try {
            $medicamento = $this->medicamentoRepository->buscarMedicamentoOrdenamiento($request);
            return response()->json($medicamento);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    public function listarMedicamentoBodega(Request $request)
    {
        $medicamentos = $this->medicamentoRepository->listarMedicamentosBodegas($request);
        return response()->json($medicamentos);
    }

    public function marcarMedicamento(Request $request)
    {
        try {
            $this->medicamentoService->marcarMedicamento($request->all());
            return response()->json([
                'mensaje' => 'Medicamento marcado con exito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'El medicamento no fue marcado!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contador()
    {
        try {
            $pendientePorLasa = $this->medicamentoRepository->pendientesPorCodigoLasa();
            return response()->json($pendientePorLasa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'No se pueden consultar los medicamentos sin codigo lasa'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarOrdenamiento($idAfiliado, $tipo)
    {
        return [$idAfiliado, $tipo];
    }

    /**
     * Listar todos los codesumis con sus medicamentos
     *
     * @return void
     * @author Calvarez
     */
    public function listarCodigosHorusPaciente(Request $request)
    {
        try {
            $codesumis = $this->medicamentoRepository->listarTodosLosMedicamentosVademecum($request);
            return response()->json($codesumis, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarMedicamento(Request $request)
    {
        try {
            $nombre = $request->input('nombre');
            return $this->medicamentoRepository->buscarMedicamento($nombre);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function principioActivo(Request $request)
    {
        try {
            $principioActivo = $request->input('principio_activo');
            return $this->medicamentoRepository->buscarPrincipioActivo($principioActivo);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


    public function crear(Request $request)
    {
        try {
            $codesumis = $this->medicamentoRepository->crearMedicamento($request);
            return response()->json($codesumis, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $responsablePqr = $this->medicamentoRepository->buscar($id);
            $responsablePqr->fill($request->all());
            $responsableUpdate = $this->medicamentoRepository->guardar($responsablePqr);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el responsable',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarMedicamentoBodegaTraslado(Request $request)
    {
        try {
            $medicamento = $this->medicamentoRepository->listarMedicamentoBodegaTraslado($request);
            return response()->json($medicamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json('Error al actualizar el responsable', Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstadoMedicamento(Request $request)
    {
        try {
            $medicamento = $this->medicamentoRepository->cambiarEstadoMedicamento($request);
            return response()->json($medicamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json('Error al actualizar el responsable', Response::HTTP_BAD_REQUEST);
        }
    }
    public function medicamentosMarcados()
    {
        try {
            $medicamnetos = $this->medicamentoRepository->medicamentosMarcados();
            return response()->json($medicamnetos);
        } catch (\Throwable $th) {
            return response()->json('Error al marcar el codesumis', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista los medicamentos para el ordenamiento de medicamentos intrahospitalario
     * @param string $nombre
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function buscarMedicamentosOrdenamientoIntrahospitalario(string $nombre): JsonResponse
    {
        try {
            $medicamentos = $this->medicamentoRepository->buscarMedicamentosOrdenamientoIntrahospitalario($nombre);
            return response()->json($medicamentos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function descargarAutorizacionFomag(DescargarAutorizacionFomagRequest $request): Response
    {
        try {
            return $this->medicamentoService->generarAutorizacionFomag(
                $request->validated()
            );
        } catch (\Throwable $e) {

            return response('Error: No se ha podido generar el archivo', 500)
                ->header('Content-Type', 'text/plain');
        }
    }
}
