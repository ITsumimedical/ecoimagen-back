<?php

namespace App\Http\Modules\Direccionamientos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Direccionamientos\Repositories\DireccionamientoRepository;
use App\Http\Modules\Direccionamientos\Requests\ActualizarParametrosRequest;
use App\Http\Modules\Direccionamientos\Requests\CrearDireccionamientoRequest;
use App\Http\Modules\Direccionamientos\Requests\CrearParametrosRequest;
use Illuminate\Http\JsonResponse;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DireccionamientoController extends Controller
{
    public function __construct(protected DireccionamientoRepository $direccionamientoRepository)
    {
        $this->direccionamientoRepository = $direccionamientoRepository;
    }

    public function crear(CrearDireccionamientoRequest $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->crearDireccionamiento($request->validated());
            return response()->json(
                [
                    'mensaje' => 'Se creo correctamente'
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->listarDireccionamiento($request);
            return response()->json(
                $consulta,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearParametro(CrearParametrosRequest $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->crearParametros($request->validated());
            if (isset($consulta['error'])) {
                return response()->json(['mensaje' => $consulta['mensaje']], 500);
            }
            return response()->json(
                [
                    'mensaje' => 'Parametrizado existosamente',
                    'data' => $consulta
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearParametroPgp(Request $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->crearParametrosPGP($request->all());
            if (isset($consulta['error'])) {
                return response()->json(['mensaje' => $consulta['mensaje']], 500);
            }
            return response()->json(
                [
                    'mensaje' => 'Parametrizado existosamente',
                    'data' => $consulta
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function listarParametros(Request $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->listarParametro($request);
            return response()->json(
                $consulta,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarParametrosPgp(Request $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->listarParametroPGP($request);
            return response()->json(
                $consulta,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    

    public function actualizarParametros(ActualizarParametrosRequest $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->actualizarParametros($request->validated());
            return response()->json(
                [
                    'mensaje' => 'Parametrización actualizada'
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el parametrización',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminaParametro(Request $request)
    {
        try {
            $consulta = $this->direccionamientoRepository->eliminarParametros($request);
            return response()->json(
                [
                    'data' => $consulta,
                    'mensaje' => 'Parametrización actualizada'
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el parametrización',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminaParametroPGP(Request $request){
        try {
            $consulta = $this->direccionamientoRepository->eliminarParametrosPGP($request);
            return response()->json(
                [
                    'data' => $consulta,
                    'mensaje' => 'Parametrización actualizada'
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el parametrización',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarDireccionamiento($direccionamiento_id)
    {
        try {
            $consulta = $this->direccionamientoRepository->eliminarDireccionamiento($direccionamiento_id);
            return response()->json(
                [
                    'data' => $consulta,
                    'mensaje' => 'Direccionamiento actualizada'
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el Direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    
    public function descargarPlantillaDireccionamiento()
    {
        try {
            $consulta = $this->direccionamientoRepository->plantilla();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function subirArchivo(Request $request) {
        try {
            $file = $request->file('file');
            $consulta = $this->direccionamientoRepository->cargar($file, $request->direccionamiento_id);
            return (new FastExcel($consulta['Error']))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function cambioDireccionamiento(Request $request) {
        try {
            $consulta = $this->direccionamientoRepository->cambio($request->all());
            return response()->json(
                $consulta,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error'=> $th->getMessage(),
                'mensaje' => 'Error al listar el direccionamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
