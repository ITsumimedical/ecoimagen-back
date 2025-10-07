<?php

namespace App\Http\Modules\Historia\Odontograma\Controllers;

use Illuminate\Http\Request;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Odontograma\Models\Odontograma;
use App\Http\Modules\Historia\Odontograma\Models\OdontogramaImagen;
use App\Http\Modules\Historia\Odontograma\Models\OdontogramaParametrizacion;
use App\Http\Modules\Historia\Odontograma\Repositories\OdontogramaRepository;
use App\Http\Modules\Historia\Odontograma\Requests\ActualizarParametrizacionOdontogramaRequest;
use App\Http\Modules\Historia\Odontograma\Services\OdontogramaService;
use App\Http\Modules\Historia\Odontograma\Services\OdontogramaServices;

class OdontogramaController extends Controller
{
    use ArchivosTrait;

	public function __construct(
        protected OdontogramaServices $odontogramaService,
		protected OdontogramaRepository $odontogramaRepository
    ) {}

    public function listar()
    {
        try {
            $consulta = OdontogramaParametrizacion::where('estado',1)->get();
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarParametros()
    {
        try {
            $consulta = OdontogramaParametrizacion::orderBy('id')->get();
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarParametrizacion(Request $request)
    {
        try {
            OdontogramaParametrizacion::create($request->all());
            return response()->json([
                'mensaje' => 'Parametrizacion Guardada Correctamente'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarOdontograma($id, Request $request)
    {
        Odontograma::where('consulta_id',$id)->delete();
        try {
            foreach ($request['diagnosticos'] as $caraDiente => $diagnosticos) {
                foreach ($diagnosticos as $diagnostico) {
                    $odontograma = new Odontograma();
                    $odontograma->tipo = 'diagnostico';
                    $odontograma->cara = $caraDiente;
                    $odontograma->consulta_id = $id;
                    $odontograma->odontograma_parametrizacion_id = $diagnostico['id'];
                    $odontograma->save();
                }
            }
            foreach ($request['tratamientos'] as $caraDiente => $tratamientos) {
                foreach ($tratamientos as $tratamiento) {
                    $odontograma = new Odontograma();
                    $odontograma->tipo = 'tratamiento';
                    $odontograma->cara = $caraDiente;
                    $odontograma->consulta_id = $id;
                    $odontograma->odontograma_parametrizacion_id = $tratamiento['id'];
                    $odontograma->save();
                }
            }
            return response()->json([
                'mensaje' => 'Odontograma Guardada Correctamente'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstadoParametros($id) {
        try {
            $consulta = OdontogramaParametrizacion::where('id',$id)->first();
            $consulta->update([
                'estado'=> $consulta->estado?0:1
            ]);
            return response()->json(['mensaje'=>'Actualizado con exito']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarOdontograma($id)
    {
        try {
            $datos = [
                'diagnosticos' => [],
                'tratamientos' => [],
                'historicoTratamientos' => []
            ];
                $consulta = Consulta::find($id);
                $odontogramaDiagnosticos = Odontograma::where('tipo','diagnostico')
                    ->join('consultas as c','c.id','odontogramas.consulta_id')
                    ->where('c.afiliado_id',$consulta->afiliado_id)
                    ->where('odontogramas.consulta_id','<=',$id)
                    ->get();
                foreach ($odontogramaDiagnosticos as $odontogramaDiagnostico) {
                    $parametrizacion = OdontogramaParametrizacion::find($odontogramaDiagnostico->odontograma_parametrizacion_id);
                    if($odontogramaDiagnostico->tipo == 'diagnostico') {
                        $datos['diagnosticos'][$odontogramaDiagnostico['cara']][] = $parametrizacion->toArray();
                    }else{
                        $datos['tratamientos'][$odontogramaDiagnostico['cara']][] = $parametrizacion->toArray();
                    }
                }
                $odontogramaTratamientoActual = Odontograma::where('tipo','tratamiento')
                    ->join('consultas as c','c.id','odontogramas.consulta_id')
                    ->where('odontogramas.consulta_id',$id)
                    ->get();
                foreach ($odontogramaTratamientoActual as $odontograma) {
                    $parametrizacion = OdontogramaParametrizacion::find($odontograma->odontograma_parametrizacion_id);
                    $datos['tratamientos'][$odontograma['cara']][] = $parametrizacion->toArray();
                }

                $historicoOdontogramasTratamientos = Odontograma::where('tipo','tratamiento')
                    ->join('consultas as c','c.id','odontogramas.consulta_id')
                    ->where('c.afiliado_id',$consulta->afiliado_id)
                    ->where('odontogramas.consulta_id','<',$id)
                    ->get();
                foreach ($historicoOdontogramasTratamientos as $odontograma) {
                    $parametrizacion = OdontogramaParametrizacion::find($odontograma->odontograma_parametrizacion_id);
                    $datos['historicoTratamientos'][$odontograma['cara']][] = $parametrizacion->toArray();
                }
            return response()->json($datos, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }


    }

    public function guardarImagen(Request $data)
    {
        if (isset($data['imagen']) && !empty($data['imagen'])) {
            $archivo = $data['imagen'];

            if ($archivo) {
                $nombre = 'odontograma' . $data['consulta_id'] . $data['tipo'].'.jpg';
                $ruta = 'odontogramas';

                $rutaArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'digital');

                $odontograma = new OdontogramaImagen();
                $odontograma->imagen = $rutaArchivo;
                $odontograma->consulta_id = $data['consulta_id'];
                $odontograma->tipo = $data['tipo'];
                $odontograma->save();

                return $odontograma;
            }
        }

        return null;
    }

	public function actualizarParametrizacion($id, ActualizarParametrizacionOdontogramaRequest $request)
	{
		try {
			$parametrizaciom = $this->odontogramaService->actualizarParametrizacion($id, $request->validated());
			return response()->json($parametrizaciom);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
		}
	}

	public function calculoCopCeo(int $afiliado_id)
	{
		try {
			$cop = $this->odontogramaService->calcularCopCeo($afiliado_id);
			return response()->json($cop);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
		}
	}

	public function calcularInforme202(int $afiliado_id)
	{
		try {
			$diagnostico = $this->odontogramaService->contarDiagnosticoInforme202($afiliado_id);
			return response()->json($diagnostico);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
		}
	}
}
