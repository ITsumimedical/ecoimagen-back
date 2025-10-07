<?php

namespace App\Http\Modules\Tutelas\Repositories;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\ActuacionTutelas\Models\ExclusionActuacionTutela;
use App\Http\Modules\ActuacionTutelas\Models\exclusionTutelas;
use App\Http\Modules\ActuacionTutelas\Repositories\ActuacionTutelaRepository;
use App\Http\Modules\AfiliadoClasificaciones\Repositories\AfiliadoClasificacionRepository;
use App\Http\Modules\AfiliadoClasificaciones\Services\AfiliadoClasificacionService;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ExclusionTutelas\Models\exclusionesTutela;
use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\ArchivosTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class TutelaRepository extends RepositoryBase
{

    use ArchivosTrait;
    public function __construct(
        private Tutela $tutelaModel,
        private AfiliadoRepository $afiliadorepository,
        private ActuacionTutelaRepository $actuacionTutelaRepository,
        private actuacionTutelas $actuacionTutelaModel,
        private ExclusionActuacionTutela $exclusionTutela,
        private AdjuntoTutelaRepository $adjuntoTutelaRepository,
        private AfiliadoClasificacionService $afiliadoClasificacionService
    ) {}

    public function tutelas($data)
    {
        if ($data->cedula_paciente != null) {

            // $afiliado = $this->afiliadorepository->citasAfiliado($data->cedula_paciente,1);
            // $consulta =  $this->tutelaModel
            //     ->WhereAfiliado($afiliado);

        } else {

            $consulta = $this->tutelaModel->with([
                'afiliado.entidad',
                'municipio',
                'juzgado',
                'actuaciones.tipoActuacion',
                'actuaciones.proceso',
                'actuaciones.adjuntosTutelas',
                'actuaciones.exlusionActuacion',
                'actuaciones.cup:id,nombre',
                'actuaciones.medicamentos:id,codesumi_id',
                'actuaciones.medicamentos.codesumi:id,nombre,codigo',
                'actuaciones' => function ($query) {
                    $query->whereIn('estado_id', [1, 6, 23, 17]);
                }
            ])
                ->whereHas('actuaciones', function ($q) {
                    $q->whereIn('estado_id', [1, 6, 23, 17]);
                })
                ->where('estado_id', $data['estado_id'])
                ->whereRadicado($data->radicado);
            if ($data->entidad_id) {
                $consulta->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->entidad_id);
                });
            }
        }

        return $data->page ? $consulta->paginate() : $consulta->get();
    }
    /**
     * La funcion me permite listar las tutelas de acuerdo con los parametros enviados en el payload. Puedo listar por numero de radicado, estado de la tutela, departamento, cedula del paciente, entidad del afiliado. 
     * @param mixed $data
     * @return LengthAwarePaginator paginador con la lista de las tutelas de acuerdo con los parametros de filtro que envie
     * @author Alejo Sanchez
     */

    public function listar($data)
    {
        $consulta = $this->tutelaModel->with([
            'afiliado.entidad',
            'municipio',
            'juzgado',
            'actuaciones.tipoActuacion',
            'actuaciones.proceso',
            'actuaciones.adjuntosTutelas',
            'actuaciones.exlusionActuacion',
            'actuaciones.cup:id,nombre',
            'actuaciones.medicamentos:id,codesumi_id',
            'actuaciones.medicamentos.codesumi:id,nombre,codigo',
            'actuaciones'

        ])
            // Filtra por el estado que le mando en el cuerpo
            ->when($data->filtro['estado_id'], function ($query) use ($data) {
                $query->where('estado_id', $data->filtro['estado_id']);
            })
            //Filtro por el numero de cedula del paciente
            ->when($data->filtro['cedula_paciente'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtro['cedula_paciente']);
                });
            })
            //filtra por el numero de radicado
            ->when(
                $data->filtro['radicado'],
                function ($query) use ($data) {
                    $query->where('radicado', $data->filtro['radicado'])->orWhere('radicado_corto', $data->filtro['radicado']);
                }
            )

            //Filtro por municipio de atención
            ->when(
                $data->filtro['municipio'],
                function ($query) use ($data) {
                    $query->where('municipio_id', $data->filtro['municipio']);
                }
            )


            //Filtro por el id de la entidad del usuario
            ->when($data->filtro['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtro['entidad_id']);
                });
            })

            //Filtro por un rango de fechas seleccionado inicio-fin
            ->when($data->filtro['fecha_inicio'] && $data->filtro['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('fecha_radica', [$data->filtro['fecha_inicio'], $data->filtro['fecha_fin']]);
            })
            //ordeno por id en direccion ascendente
            ->orderBy('id','asc')
            
            //paginador que va depender de la cantidad de registros y el numero de pagina que le mande desde el front
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);

        return $consulta;
    }

    public function cerrarTutela($tutela_id)
    {
        return $this->tutelaModel->where('tutelas.id', $tutela_id)->update([
            'estado_id' => 17
        ]);
    }


    public function cerrarTutelaTemporal($tutela_id)
    {
        try {
            return $this->tutelaModel->where('tutelas.id', $tutela_id)->whereIn('estado_id', [1, 6])->update(['estado_id' => 23]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Cambia el estado de una tutela a 1 (no asignado) al recibir una información que contenga una tutela_id
     * @param $data -> Objeto que contiene información de actuación de una tutela, e incluye el id de la tutela a abrir
     * @return bool|Exception
     * @author AlejoSR
     */
    public function abrirTutela($data): bool|Exception
    {
        try {
            $this->tutelaModel->where('tutelas.id', $data['tutela_id'])->update(['estado_id' => 1]);
            return true;
        } catch (\Throwable $th) {
            throw new Exception('Error al realizar la consulta', 0, $th);
        }
    }

    public function actualizarEstadoAsignado($data)
    {
        $this->tutelaModel->where('tutelas.id', $data)->update(['estado_id' => 6]);
    }

    public function crear($data)
    {

        DB::beginTransaction();

        try {
            

            $tutela = $this->tutelaModel->create([
                'radicado' => $data["radicado"],
                'fecha_radica' => $data["fecha_radica"],
                'observacion' => $data["observacion"],
                'quien_creo_id' => auth()->user()->id,
                'afiliado_id' => $data["afiliado_id"],
                'municipio_id' => $data["municipio_id"],
                'juzgado_id' => $data["juzgado_id"],
                'dias' => $data["dias"],
                'radicado_corto' =>$data["radicado_corto"],
                'estado_id' => 1
            ]);
           
            $data["tutela_id"] = $tutela->id;
            $data["quien_creo_id"] = auth()->user()->id;


            $actuacion_tutelas = $this->actuacionTutelaModel->create([
                'direccion' => $data["direccion"],
                'telefono' => $data["telefono"],
                'observacion' => $data["observacion"],
                'celular' => $data["celular"],
                'correo' => $data["correo"],
                'continuidad' => $data["continuidad"],
                'exclusion' => $data["exclusion"],
                'integralidad' => $data["integralidad"],
                'dias' => $data["dias"],
                'novedad_registro' => $data["novedad_registro"],
                'gestion_documental' => $data["gestion_documental"],
                'medicina_laboral' => $data["medicina_laboral"],
                'reembolso' => $data["reembolso"],
                'transporte' => $data["transporte"],
                'fecha_radica' => $data["fecha_radica"],
                'tipo_actuacion_id' => $data["tipo_actuacion_id"],
                'quien_creo_id' => auth()->user()->id,
                'tutela_id' => $data["tutela_id"],
                'estado_id' => 1,
                'hospitalizacion' => $data['hospitalizacion'],
                'reintegro_laboral' => $data['reintegro_laboral'],

            ]);

            if ($data['medicamentos']) {
                $actuacion_tutelas->medicamentos()->sync($data['medicamentos']);
            }

            if ($data['cups']) {
                $actuacion_tutelas->cup()->sync($data['cups']);
            }


            $data["tutela_id"] = $actuacion_tutelas->id;

            foreach ($data['proceso_id'] as $item) {
                $actuacion_tutelas->proceso()->attach($item);
            }

            if ($data['exclusiones']) {
                foreach ($data["exclusiones"] as $exclusion) {
                    $this->exclusionTutela->create([
                        'actuacion_tutela_id' => $actuacion_tutelas->id,
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

                    $this->adjuntoTutelaRepository->crearAdjuntoActuacion($subirArchivo, $nombre, $actuacion_tutelas->id);
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return $th->getMessage();
        }

        
    }

    /**
     * Lista todas las tutelas de un afiliado que estan en estado abierto (sin asignar, asignado, cerrado temporal)
     * @return array
     */
    public function listarTutelasAbiertas($id_afiliado){
            return $this->tutelaModel->where('afiliado_id', $id_afiliado)->where('estado_id','<>',17)->get();
    }

    /**
     * Consultar todas las tutelas con un id
     * @param mixed $id_tutela
     * @return 
     */
    public function listarTutelas($id_tutela){
        return $this->tutelaModel->where('tutelas.id', $id_tutela)->first();
    }
}
