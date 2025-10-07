<?php

namespace App\Http\Modules\InteroperabilidadMesaAyuda\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ClienteMesaAyuda\Services\ClientesMesaAyudaService;
use App\Http\Modules\InteroperabilidadMesaAyuda\Http\MedicinaIntegralHttp;
use App\Http\Modules\InteroperabilidadMesaAyuda\Services\InteroperabilidadMesaAyudaService;
use App\Http\Modules\MesaAyuda\MesaAyuda\Repositories\MesaAyudaRepository;
use App\Http\Modules\Ordenamiento\Http\FomagHttp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Modules\MesaAyuda\MesaAyuda\Services\MesaAyudaService;


class InteroperabilidadMesaAyudaController extends Controller
{
    private  $fomagHttp;
    private  $MedicinaIntegralHttp;
    private  $interoperabilidadMesaAyudaService;
    private  $mesaAyudaService;
    public function __construct(
        InteroperabilidadMesaAyudaService $interoperabilidadMesaAyudaService,
        FomagHttp  $fomagHttp,
        MesaAyudaService $mesaAyudaService,
        MedicinaIntegralHttp $MedicinaIntegralHttp,
        protected readonly MesaAyudaRepository $mesaAyudaRepository,
    ) {
        $this->fomagHttp = $fomagHttp;
        $this->interoperabilidadMesaAyudaService = $interoperabilidadMesaAyudaService;
        $this->mesaAyudaService = $mesaAyudaService;
        $this->MedicinaIntegralHttp = $MedicinaIntegralHttp;
    }

    /**
     * lista la mesa de ayuda de una entidad en particular
     * @param Request $request
     * @param string $entidad
     */
    public function listar(Request $request, string $entidad)
    {
        try {
            $service = $this->getService($entidad);

            if ($service) {

                if ($entidad === 'fomag' || $entidad === 'medicinaintegral') {
                    $lista = $service->getDatos($request->all());
                } elseif ($entidad === 'sumimedical') {
                    $lista = $service->listarMisCasos($request);
                } else {
                    throw new \Exception("Entidad no soportada: $entidad");
                }
            }

            return response()->json($lista, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => "Error al consultar los datos de $entidad!",
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function mesaFomag(Request $request)
    {
        try {
            $response = $this->fomagHttp->getDatos($request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function mesaMedicinaIntegral(Request $request)
    {
        try {
            $res  = $this->interoperabilidadMesaAyudaService->mesaMedicinaIntegral($request->all());
            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function categoriasFomag(Request $request)
    {
        try {
            $response = $this->fomagHttp->categoriasFomag($request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function reasignarMesaAyudaFomag(int $id, Request $request)
    {
        try {
            $res = $this->fomagHttp->reasignarMesaAyudaFomag($id, $request->all());

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function comentarioMesaAyudaFomag(int $id, Request $request)
    {
        try {
            $res = $this->fomagHttp->comentarioMesaAyudaFomag($id, $request->all());

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    // FUNCION ECHA PARA LISTAR EN EL MODAL LOS COMENTARIOS Y GESTIONES DE LA INTEROPERABILIDAD

    public function listarComentariosMesaAyudaFomag($id, Request $request)
    {
        try {
            $response = $this->fomagHttp->listarComentariosMesaAyudaFomag((int) $id, $request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    // FUNCION ECHA PARA SOLUCIONAR EL CASO EN LA INTEROPERABILIDAD DE LA MESA DE AYUDA DE FOMAG

    public function solucionarMesaAyudaFomag(Request $request, int $id)
    {
        try {
            $res = $this->fomagHttp->solucionarMesaAyudaFomag($id, $request->all());

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function listarCategoriasMedicinaIntegral(Request $request)
    {
        try {
            $response = $this->MedicinaIntegralHttp->listarCategoriasMedicinaIntegral($request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function reasignarMesaAyudaMedicinaIntegral(int $id, Request $request)
    {
        try {
            $response = $this->MedicinaIntegralHttp->reasignarMesaAyudaMedicinaIntegral($id, $request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function comentarioMesaAyudaMedicinaIntegralInteroperabilidad(int $id, Request $request)
    {
        try {
            $response = $this->MedicinaIntegralHttp->comentarioMesaAyudaMedicinaIntegralInteroperabilidad($id, $request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function listarComentariosMesaAyudaMedicinaIntegral($id, Request $request)
    {
        try {
            $response = $this->MedicinaIntegralHttp->listarComentariosMesaAyudaMedicinaIntegral((int) $id, $request->all());

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function solucionarMesaAyudaMedicinaIntegral(Request $request, int $id)
    {
        try {
            $res = $this->MedicinaIntegralHttp->solucionarMesaAyudaMedicinaIntegral($id, $request->all());

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function consultarAdjuntosFomag(int $id)
    {
        try {
            $res = $this->fomagHttp->consultarAdjuntosFomag($id);

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Fomag!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function consultarAdjuntosMedicinaIntegral(int $id)
    {
        try {
            $res = $this->MedicinaIntegralHttp->consultarAdjuntosMedicinaIntegral($id);

            return response()->json($res, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los datos de Medicina Integral!.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * determina que servicio debe de usarse
     * @param string $entidad
     */
    private function getService(string $entidad)
    {
        return match ($entidad) {
            'fomag' => new FomagHttp(),
            'medicinaintegral' => new InteroperabilidadMesaAyudaService(),
            'sumimedical' => $this->mesaAyudaRepository,
            default => throw new \Exception("Entidad no soportada: $entidad"),
        };
    }
}
