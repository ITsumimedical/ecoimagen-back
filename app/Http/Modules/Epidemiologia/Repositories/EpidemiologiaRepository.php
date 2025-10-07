<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Epidemiologia\Models\CabeceraSivigila;
use App\Http\Modules\Epidemiologia\Models\ObservacionRegistroSivigila;
use App\Http\Modules\Epidemiologia\Models\RegistroSivigila;
use App\Http\Modules\Epidemiologia\Models\RespuestaSivigila;
use App\Mail\EnvioMensajeDevolucionFichaEpidemiologia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EpidemiologiaRepository extends RepositoryBase
{

    protected $cabeceraModel;
    protected $respuestaModel;
    protected $registroModel;

    public function __construct(CabeceraSivigila $cabeceraModel, RespuestaSivigila $respuestaModel, RegistroSivigila $registroModel)
    {
        $this->cabeceraModel = $cabeceraModel;
        $this->respuestaModel = $respuestaModel;
        $this->registroModel = $registroModel;
    }

    /**
     * Lista las cabeceras segun el id del evento que llegue
     * @param int $id
     * @return Collection
     * @author Sofia O
     */
    public function listarCabeceraConCampos(int $id)
    {
        return $this->cabeceraModel::with([
            'campoSivigila' => function ($query) {
                $query->where('estado_id', 1)
                    ->with(['OpcionesCampoSivigila' => function ($q) {
                        $q->where('estado_id', 1)
                        ->orderBy('id', 'asc');
                    }])
                    ->orderBy('id', 'asc');
            }
        ])
            ->where('evento_id', $id)
            ->where('estado_id', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Guarda las respuestas que llegan en el array $data
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function guardarRespuestas(array $data)
    {
        return $this->respuestaModel->insert($data);
    }

    /**
     * Crear el registro de la ficha epidemiologica
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearRegistroSivigila(array $data)
    {
        return $this->registroModel->create($data);
    }

    /**
     * lista por rep usuario y consulta los diagnostico registrados en la ficha epidemiologia
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarConsultaDiagnosticoEpidemiologia(array $data)
    {

        $cie10Permitidos = config('cie10epidemiologiapermitidos.cie10s');
        $userIpsId = Auth::user()->reps->id;

        $diaginsticos = $this->registroModel
            ->whereHas('eventoSivigila.cie10', function ($query) use ($cie10Permitidos) {
                $query->whereIn('codigo_cie10', $cie10Permitidos);
            })
            ->when($userIpsId, function ($query) use ($userIpsId) {
                $query->whereHas('consulta.afiliado.ips', function ($q) use ($userIpsId) {
                    $q->where('id', $userIpsId);
                });
            })
            ->with([
                'eventoSivigila.resgistroSivigila:id',
                'eventoSivigila.cie10:id,evento_id,codigo_cie10',
                'consulta:id,afiliado_id,medico_ordena_id',
                'consulta.afiliado:id,numero_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,ips_id',
                'consulta.afiliado.ips:id,nombre',
                'consulta.medicoOrdena.operador',
                'cie10:id,evento_id,codigo_cie10'
            ]);

        if (!empty($data['documento'])) {
            $diaginsticos->whereHas('consulta.afiliado', function ($query) use ($data) {
                $query->WhereDocumentos($data['documento']);
            });
        }

        if (!empty($data['evento'])) {
            $diaginsticos->whereHas('eventoSivigila', function ($query) use ($data) {
                $query->WhereNombreEvento($data['evento']);
            });
        }

        if (!empty($data['estado'])) {
            $diaginsticos->where('estado_id', $data['estado']);
        }

        if (!empty($data['fichaId'])) {
            $diaginsticos->WhereFichaId($data['fichaId']);
        }

        return $diaginsticos
            ->orderBy('created_at', 'desc')
            ->paginate($data['cantidad']);
    }

    /**
     * lista todos los registro y consulta los diagnostico registrados en la ficha epidemiologia
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarTodasConsultaDiagnosticoEpidemiologia(array $data)
    {

        $cie10Permitidos = config('cie10epidemiologiapermitidos.cie10s');

        $diaginsticos = $this->registroModel
            ->whereHas('eventoSivigila.cie10', function ($query) use ($cie10Permitidos) {
                $query->whereIn('codigo_cie10', $cie10Permitidos);
            })
            ->with([
                'eventoSivigila.resgistroSivigila:id',
                'eventoSivigila.cie10:id,evento_id,codigo_cie10',
                'consulta:id,afiliado_id,medico_ordena_id',
                'consulta.afiliado:id,numero_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,ips_id',
                'consulta.afiliado.ips:id,nombre',
                'consulta.medicoOrdena.operador',
                'cie10:id,evento_id,codigo_cie10'
            ]);

        if (!empty($data['documento'])) {
            $diaginsticos->whereHas('consulta.afiliado', function ($query) use ($data) {
                $query->WhereDocumentos($data['documento']);
            });
        }

        if (!empty($data['evento'])) {
            $diaginsticos->whereHas('eventoSivigila', function ($query) use ($data) {
                $query->WhereNombreEvento($data['evento']);
            });
        }

        if (!empty($data['estado'])) {
            $diaginsticos->where('estado_id', $data['estado']);
        }

        if (!empty($data['ips'])) {
            $diaginsticos->whereHas('consulta.afiliado.ips', function ($query) use ($data) {
                $query->where('id', $data['ips']);
            });
        }

        if (!empty($data['fichaId'])) {
            $diaginsticos->WhereFichaId($data['fichaId']);
        }

        return $diaginsticos
            ->orderBy('created_at', 'desc')
            ->paginate($data['cantidad']);
    }

    /**
     * Se actualiza el estado del registro a revisado con el id del registro al que pertenece
     * @param array $data
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function actualizarEstadoFormulario(array $data, int $id)
    {
        $estado = $this->registroModel->find($id);
        $estado->estado_id = $data['estado_id'];
        return $estado->update();
    }

    /**
     * Se crea la consulta que se va enviar a mi blade pñara mostrarala en el pdf
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function generarDatosFichaNotificacion(int $id)
    {
        $registro = $this->registroModel::select('registro_sivigilas.*', 'oficios.nombre_oficio', 'oficios.codigo_ciuo')
            ->join('consultas', 'consultas.id', '=', 'registro_sivigilas.consulta_id')
            ->join('afiliados', 'afiliados.id', '=', 'consultas.afiliado_id')
            ->leftJoin('oficios', function ($join) {
                $join->on('afiliados.ocupacion', '=', 'oficios.nombre_oficio');
            })
            ->where('registro_sivigilas.id', $id)
            ->with([
                'eventoSivigila.cie10:id,evento_id,codigo_cie10',
                'eventoSivigila.cabeceraSivigila.campoSivigila.opcionesCampoSivigila',
                'consulta:id,afiliado_id,medico_ordena_id,cita_no_programada,rep_id,agenda_id',
                'consulta.rep:id,tipo_zona,direccion,municipio_id,codigo_habilitacion,numero_sede,codigo_habilitacion,nombre',
                'consulta.rep.municipio:id,nombre,departamento_id,codigo_dane',
                'consulta.rep.municipio.departamento:id,nombre,codigo_dane',
                'consulta.agenda:id,consultorio_id',
                'consulta.agenda.consultorio:id,rep_id',
                'consulta.agenda.consultorio.rep:id,tipo_zona,direccion,municipio_id,numero_sede,codigo_habilitacion,nombre',
                'consulta.agenda.consultorio.rep.municipio:id,nombre,departamento_id,codigo_dane',
                'consulta.agenda.consultorio.rep.municipio.departamento:id,nombre,codigo_dane',
                'consulta.afiliado',
                'consulta.afiliado.entidad:id,nombre',
                'consulta.afiliado.departamento_afiliacion',
                'consulta.afiliado.municipio_afiliacion',
                'consulta.afiliado.pais_afiliado',
                'consulta.medicoOrdena.operador',
                'respuestaSivigila.campoSivigila',
                'cie10:id,evento_id,codigo_cie10'
            ])
            ->first();
        return $registro->toArray();
    }

    // /**
    //  * Se listan solo las ips que tengan registros creados
    //  * @author Sofia O
    //  */
    // public function listarIps()
    // {
    //     return $this->registroModel->with(['consulta:id,afiliado_id', 'consulta.afiliado:id,ips_id', 'consulta.afiliado.ips:id,nombre'])->get();
    // }

    /**
     * Actualizar las respuestas de la ficha
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function actualizarRespuestas(array $data)
    {
        foreach ($data as $respuesta) {
            RespuestaSivigila::where('id', $respuesta['id'])
                ->where('campo_id', $respuesta['campo_id'])
                ->where('consulta_id', $respuesta['consulta_id'])
                ->update([
                    'respuesta_campo' => $respuesta['respuesta_campo'] ?? null
                ]);
        }
    }

    public function obtenerRespuestas($data)
    {
        return $this->respuestaModel::with('registroSivigila:id,evento_id,consulta_id,cie10_id', 'registroSivigila.consulta:id,afiliado_id')
            ->whereHas('registroSivigila', function ($query) use ($data) {
                $query->where('evento_id', $data['evento_id']);
            })
            ->whereHas('registroSivigila.consulta', function ($query) use ($data) {
                $query->where('afiliado_id', $data['afiliado_id']);
            })
            ->whereHas('registroSivigila', function ($query) use ($data) {
                $query->where('consulta_id', $data['consulta_id']);
            })
            ->whereHas('registroSivigila', function ($query) use ($data) {
                $query->where('cie10_id', $data['cie10_id']);
            })
            ->get();
    }

    /**
     * Cambia el estado y envia un correo con el id y evento del registo
     * @param Array @data
     * @param int $id
     * @author Sofia O
     */
    public function devolverFichaMedico(array $data, int $id)
    {
        $registro = $this->registroModel->with('eventoSivigila:id,nombre_evento', 'consulta:id,afiliado_id', 'consulta.afiliado:id,numero_documento')->findOrFail($id);

        $observacion = ObservacionRegistroSivigila::create([
            'observacion' => $data['observacion'],
            'email_medico' => $data['email_medico'],
            'user_id' => Auth::id(),
            'registro_id' => $registro['id'],
        ]);

        $registro->estado_id = $data['estado_id'];
        $registro->save();

        Mail::to($data['email_medico'])->send(new EnvioMensajeDevolucionFichaEpidemiologia($data['observacion'], $registro->id, $registro->eventoSivigila->nombre_evento, $registro->consulta->afiliado->numero_documento));

        return $observacion;
    }

    /**
     * Listas las observaciones de cada registro
     * @param int $id
     * @author Sofia O
     */
    public function listarObservacionesDevolucion(int $id)
    {
        $observaciones = ObservacionRegistroSivigila::where('registro_id', $id)->with('user.operador:id,user_id,nombre,apellido')->get();
        return $observaciones;
    }
}
