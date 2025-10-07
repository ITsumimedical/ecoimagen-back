<?php

namespace App\Http\Modules\ActuacionTutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\ActuacionTutelas\Models\ExclusionActuacionTutela;
use App\Http\Modules\ResponsableTutela\Models\ResponsableTutela;
use App\Http\Modules\Tutelas\Repositories\AdjuntoTutelaRepository;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActuacionTutelaRepository extends RepositoryBase
{

    use ArchivosTrait;

    public function __construct(
        private actuacionTutelas $actuacionTutelaModel,
        private AdjuntoTutelaRepository $adjuntoTutelaRepository,
        private ExclusionActuacionTutela $exclusionTutela,

    ) {}

    /**
     * Crea los datos de actuación de una accion constitucional a partir del objeto data recibido con informacion necesaria para la creación de la actuación en la base de datos. Se sincroniza con las tablas de medicamentos, cups, procesos relacionados con actuaciones, asi como exclusiones y adjunta los archivos en caso de que los haya
     * @param mixed $data -> Objeto con información para creación de una actuacion
     * @return bool|string
     * @author AlejoSR
     */
    public function crearActuacionTutela($data): bool|string
    {

        DB::beginTransaction();
        try {
            $actuacion = actuacionTutelas::create([
                'direccion' => $data["direccion"],
                'telefono' => $data["telefono"],
                'celular' => $data["celular"],
                'correo' => $data["correo"],
                'continuidad' => $data["continuidad"],
                'exclusion' => $data["exclusion"],
                'integralidad'  => $data["integralidad"],
                'dias' => $data["dias"],
                'novedad_registro' => $data["novedad_registro"],
                'tutela_id' => $data["tutela_id"],
                'medicina_laboral' => $data["medicina_laboral"],
                'reembolso' => $data["reembolso"],
                'transporte' => $data["transporte"],
                'fecha_radica' => $data["fecha_radica"],
                'tipo_actuacion_id' => $data["tipo_actuacion_id"],
                'proceso_id' => $data["proceso_id"],
                'quien_creo_id' => Auth::id(),
                'observacion' => $data["observacion"],
                'gestion_documental' => $data['gestion_documental'],
                'reintegro_laboral' => $data['reintegro_laboral'],
                'hospitalizacion' => $data['hospitalizacion'],
                'estado_id' => 1,
            ]);

            if ($data['medicamentos']) {
                $actuacion->medicamentos()->sync($data['medicamentos']);
            }

            if ($data['cups']) {
                $actuacion->cup()->sync($data['cups']);
            }

            foreach ($data['proceso_id'] as $proceso) {
                $actuacion->proceso()->sync($proceso);
            }

            if ($data['exclusiones']) {
                foreach ($data['exclusiones'] as $exclusion) {
                    $this->exclusionTutela->create([
                        'actuacion_tutela_id' => $actuacion->id,
                        'user_id' => auth()->user()->id,
                        'exclusion' => $exclusion
                    ]);
                }
            }

            if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
                $archivos = $data['adjuntos'];
                $ruta = 'adjuntosActuacionTutela';
                foreach ($archivos as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                    $this->adjuntoTutelaRepository->crearAdjuntoActuacion($subirArchivo, $nombre, $actuacion->id);
                }
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function listarActuaciones($data, $id)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if ($data->page) {
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('tutela_id', $id);
        } else {
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('tutela_id', $id)
                ->get();
        }
    }

    public function listarPorId($id)
    {
        return $this->actuacionTutelaModel
            ->where('actuacion_tutelas.id', $id)
            ->with('tipoActuacion:id,nombre')
        ;
    }

    public function listarAsignada($request)
    {
        $actuaciones = actuacionTutelas::select('actuacion_tutelas.*')
            ->join('tutelas', 'tutelas.id', 'actuacion_tutelas.tutela_id')
            ->where('actuacion_tutelas.estado_id', 6)
            ->with([
                'tutela.municipio',
                'tutela.juzgado',
                'tutela.afiliado.entidad',
                'tipoActuacion',
                'adjuntosTutelas',
                'exlusionActuacion',
                'cup:id,nombre',
                'medicamentos:id,codesumi_id',
                'medicamentos.codesumi:id,nombre,codigo',
                'proceso.responsableTutela' => function ($query) use ($request) {
                    $query->where('user_id', $request['id']);
                }
            ])
            ->whereHas('proceso.responsableTutela', function ($query) use ($request) {
                $query->where('user_id', $request['id']);
            });

        return $request->page ? $actuaciones->orderBy('id','asc')->paginate($request->cant) : $actuaciones->orderBy('id','asc')->get();
    }

    public function listarAsignadaCerrada($data)
    {
        $actuaciones = actuacionTutelas::select([
            'actuacion_tutelas.*'

        ])
            ->join('tutelas', 'tutelas.id', 'actuacion_tutelas.tutela_id')
            ->where('actuacion_tutelas.estado_id', 17)
            ->with([
                'tutela.municipio',
                'tutela.juzgado',
                'tutela.afiliado.entidad',
                'tipoActuacion',
                'adjuntosTutelas',
                'exlusionActuacion',
                'cup:id,nombre',
                'medicamentos:id,codesumi_id',
                'medicamentos.codesumi:id,nombre,codigo',
                'proceso.responsableTutela' => function ($query) use ($data) {
                    $query->where('user_id', $data['id']);
                }
            ])
            ->whereHas('proceso.responsableTutela', function ($query) use ($data) {
                $query->where('user_id', $data['id']);
            });

        return $data->page ? $actuaciones->orderBy('id','asc')->paginate($data->cant) : $actuaciones->orderBy('id','asc')->get();
    }

    public function listarCerradaTemporal($data)
    {
        try {
            $actuaciones = actuacionTutelas::select([
                'actuacion_tutelas.*'

            ])
                ->join('tutelas', 'tutelas.id', 'actuacion_tutelas.tutela_id')
                ->where('actuacion_tutelas.estado_id', 23)
                ->with([
                    'tutela.municipio',
                    'tutela.juzgado',
                    'tutela.afiliado.entidad',
                    'tipoActuacion',
                    'adjuntosTutelas',
                    'exlusionActuacion',
                    'cup:id,nombre',
                    'medicamentos:id,codesumi_id',
                    'medicamentos.codesumi:id,nombre,codigo',
                    'proceso.responsableTutela' => function ($query) use ($data) {
                        $query->where('user_id', $data['id']);
                    }
                ])
                ->whereHas('proceso.responsableTutela', function ($query) use ($data) {
                    $query->where('user_id', $data['id']);
                });

            return $data->page ? $actuaciones->orderBy('id','asc')->paginate($data->cant) : $actuaciones->orderBy('id','asc')->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }



    public function asignarActuacion($data)
    {

        #sincronizco y asigno los responsables de todos los procesos
        $actuacion = $this->actuacionTutelaModel->find($data['actuacion_tutelas_id']);

        $actuacion->proceso()->sync([]);

        foreach ($data['proceso_tutela_id'] as $proceso) {
            if (isset($proceso['id'])) {
                $actuacion->proceso()->attach([$proceso['id']]);
            } else {
                $actuacion->proceso()->attach([$proceso]);
            }
        }

        $actuacion->update(['estado_id' => 6]);


        $actuacion->save();
        


        #retorno el mensaje de la actuacion creada
        return $actuacion;
    }

    /**
     * Permite realizar actualizar el estado de una actuacion de acuerdo al id de la tutela que recibe como parametro
     * @param mixed $tutela_id
     * @return mixed $data
     * @author AlejoSR
     */
    public function cerrarActuacionTemporal($tutela_id)
    {
        try {
            $cierre = $this->actuacionTutelaModel->where('tutela_id', $tutela_id)->whereIn('estado_id', [1, 6])->update(['estado_id' => 23]);

            return $cierre;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Recibe un id de tutela y con base en este actualiza el estado de las actuaciones que esten relacionadas con esa tutela a 17, cerrandolas todas
     * @param int $tutela_id
     * @return bool|string
     * @author AlejoSR
     */
    public function cerrarActuacion(int $tutela_id)
    {
        try {
            return $this->actuacionTutelaModel->where('tutela_id', $tutela_id)->whereIn('estado_id', [1, 6, 23])->update(['estado_id' => 17]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    /**
     * Recibe un id de la actuacion que se desea abrir y se actualiza su estado a 1 (no asignado)
     * @param mixed $data
     * @return bool|string
     */
    // public function abrirActuacion($data)
    // {

    //     try {
    //         $this->actuacionTutelaModel->where('actuacion_tutelas.id', $data['actuacion_tutela_id'])->update(['estado_id' => 1]);

    //         return true;
    //     } catch (\Throwable $th) {
    //         return $th->getMessage();
    //     }
    // }
}
