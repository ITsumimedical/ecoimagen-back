<?php

namespace App\Http\Modules\Afiliados\Repositories;

use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Georeferenciacion\Models\Georeferenciacion;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Colegios\Models\Colegio;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Paises\Models\Pais;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AfiliadoRepository extends RepositoryBase
{
    protected $afiliadoModel;
    protected $novedadAfiliadoRepository;

    public function __construct(Afiliado $afiliadoModel, NovedadAfiliadoRepository $novedadAfiliadoRepository)
    {
        $this->afiliadoModel = $afiliadoModel;
        $this->novedadAfiliadoRepository = $novedadAfiliadoRepository;
    }

    /**
     * Consultar datos de un afiliado por cédula y tipo de documento.
     *
     * @param string $cedula
     * @param string $tipoDocumento
     * @return Response
     */
    public function consultarDatosAfiliado($cedula, $tipo_documento)
    {
        $entidades = json_decode(Auth::user()->entidad);
        $arrEntidades = array_column($entidades, 'id');

        return $this->afiliadoModel
            ->where('numero_documento', $cedula)
            ->where('tipo_documento', $tipo_documento)
            ->whereIn('entidad_id', $arrEntidades)
            ->whereIn('estado_afiliacion_id', [1, 31, 32, 33])
            ->with([
                'clasificacion',
                'caracterizacionAfiliado:id,afiliado_id,estratificacion_riesgo,grupo_riesgo,user_gestor_id,user_enfermeria_id',
                'caracterizacionAfiliado.usuarioGestor.operador',
                'caracterizacionAfiliado.usuarioEnfermeria.operador',
                'ips:id,nombre',
                'tipoDocumento:id,nombre,sigla',
                'entidad:id,nombre',
                'EstadoAfiliado:id,nombre',
                'TipoAfiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'municipio_atencion:id,nombre,codigo_dane',
                'departamento_atencion:id,nombre,codigo_dane',
                'municipio_afiliacion:id,nombre,codigo_dane',
                'departamento_afiliacion:id,nombre,codigo_dane',
                'medico.operador',
                'medico2.operador',
                'colegios:id,nombre',
                'user:id,email',
            ])->get();
    }


    // //Consultar datos de los afiliados en estado activo, proteccion laboral cotizante, proteccion laboral beneficiario y retirados
    // por cedula y tipo de documento
    public function consultarAfiliados($cedula, $tipoDocumento)
    {
        $entidades = json_decode(Auth::user()->entidad);
        $arrEntidades = array_column($entidades, 'id');

        return $this->afiliadoModel::select(
            'id',
            'id_afiliado',
            'region',
            'primer_nombre',
            'segundo_nombre',
            'primer_apellido',
            'segundo_apellido',
            'tipo_documento',
            'numero_documento',
            'sexo',
            'fecha_afiliacion',
            'fecha_nacimiento',
            'telefono',
            'celular1',
            'celular2',
            'correo1',
            'correo2',
            'direccion_residencia_cargue',
            'direccion_residencia_numero_exterior',
            'direccion_residencia_via',
            'direccion_residencia_numero_interior',
            'direccion_residencia_interior',
            'direccion_residencia_barrio',
            'discapacidad',
            'grado_discapacidad',
            'parentesco',
            'tipo_documento_cotizante',
            'numero_documento_cotizante',
            'departamento_afiliacion_id',
            'municipio_afiliacion_id',
            'departamento_atencion_id',
            'municipio_atencion_id',
            'ips_id',
            'medico_familia1_id',
            'medico_familia2_id',
            'estado_afiliacion_id',
            'tipo_afiliacion_id',
            'dpto_residencia_id',
            'mpio_residencia_id',
            'entidad_id',
            'tipo_afiliado_id',
            'pais_id',
            'grupo_sanguineo',
            'nivel_educativo',
            'ocupacion',
            'estado_civil',
            'orientacion_sexual',
            'identidad_genero',
            'nombre_acompanante',
            'telefono_acompanante',
            'nombre_responsable',
            'telefono_responsable',
            'parentesco_responsable',
            'colegio_id',
            'salario_minimo_afiliado',
            'plan',
            'categoria',
            'localidad',
            'ciclo_vida_atencion',
            'edad_cumplida',
            'etnia',
            'zona_vivienda'
        )
            ->where('numero_documento', $cedula)
            ->where('tipo_documento', $tipoDocumento)
            ->whereIn('entidad_id', $arrEntidades)
            ->whereIn('estado_afiliacion_id', [1, 31, 32, 33])
            ->with([
                'clasificacion' => function ($query) {
                    $query->wherePivot('estado', true);
                },
                'caracterizacionAfiliado:id,afiliado_id,estratificacion_riesgo,grupo_riesgo,user_gestor_id,user_enfermeria_id',
                'caracterizacionAfiliado.usuarioGestor.operador',
                'caracterizacionAfiliado.usuarioEnfermeria.operador',
                'ips:id,nombre',
                'tipoDocumento:id,nombre,sigla',
                'entidad:id,nombre',
                'EstadoAfiliado:id,nombre',
                'TipoAfiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'municipio_atencion:id,nombre,codigo_dane',
                'departamento_atencion:id,nombre,codigo_dane',
                'municipio_afiliacion:id,nombre,codigo_dane',
                'departamento_afiliacion:id,nombre,codigo_dane',
                'medico.operador',
                'medico2.operador',
                'colegios:id,nombre',
            ])
            ->get();
    }


    /**
     * Consulta los datos de un afiliado en la web, incluyendo citas y otros detalles.
     *
     * @param object $datos Contiene la fecha de nacimiento y el número de documento del afiliado.
     * @return mixed Retorna los datos del afiliado si se encuentra, o null si no se encuentra.
     */
    public function consultaWebAfiliado($datos)
    {
        return $this->afiliadoModel
            ->with([
                'tipoDocumento:id,nombre',
                'entidad:id,nombre',
                'tipo_afiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'EstadoAfiliado:id,nombre',
                'departamento_atencion:id,nombre',
                'municipio_atencion:id,nombre',
                'colegios:id,nombre',
                'ips:id,nombre',
                'user:id,email'
            ])
            ->where('fecha_nacimiento', $datos->fecha)
            ->where('numero_documento', $datos->documento)
            ->whereIn('estado_afiliacion_id', [1, 32, 33])
            ->first();
    }

    /**
     * Obtener datos de un afiliado por su cédula.
     *
     * @param string $cedula
     * @return mixed
     */
    public function obtenerDatosAfiliado($cedula)
    {
        return $this->afiliadoModel->WhereBeneficiarios($cedula)->first();
    }

    /**
     * Crear un nuevo afiliado y un usuario asociado.
     *
     * @param Request $request
     * @return void
     */
    public function crearAfiliado(Request $request)
    {
        // Crear Usuario
        $user = User::create([
            'email' => $request['numero_documento'] . '@sumimedical.com',
            'password' => bcrypt($request['numero_documento']),
            'tipo_usuario_id' => 2,
            'reps_id' => 13739,
            'activo' => true,
        ]);

        // Preparar datos del afiliado
        $afiliadoData = $request->all();
        $afiliadoData['id_afiliado'] = '0';
        $afiliadoData['primer_nombre'] = strtoupper($request['primer_nombre']);
        $afiliadoData['segundo_nombre'] = strtoupper($request['segundo_nombre'] ?? '');
        $afiliadoData['primer_apellido'] = strtoupper($request['primer_apellido']);
        $afiliadoData['segundo_apellido'] = strtoupper($request['segundo_apellido'] ?? '');
        $afiliadoData['user_id'] = $user->id;

        // Crear Afiliado
        $consulta = $this->afiliadoModel->create($afiliadoData);
        $this->novedadAfiliadoRepository->crearNovedadAfiliado($consulta->id, $request);
    }

    /**
     * Cambiar el estado de un afiliado.
     *
     * @param Request $request
     * @param int $estado_id
     * @return bool
     */
    public function cambiarEstado(Request $request, $estado_id)
    {
        $afiliado = Afiliado::find($estado_id);
        $afiliado->estado_afiliacion_id = $request['estado_afiliacion_id'];
        return $afiliado->update();
    }

    /**
     * Obtener datos de un afiliado por su ID.
     *
     * @param int $id_afiliado
     * @return mixed
     */
    public function obtenerDatosAfiliadoPorId($id_afiliado)
    {
        return $this->afiliadoModel->find($id_afiliado, ['medico_familia1_id']);
    }

    /**
     * Obtener datos de afiliados activos por documento y tipo de documento.
     *
     * @param string $numero_documento
     * @param string $tipo_documento
     * @return mixed
     */
    public function afiliadosActivos($numero_documento, $tipo_documento)
    {
        $afiliado = $this->afiliadoModel->select(
            'afiliados.id',
            'id_afiliado',
            'region',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'tipo_documento',
            'numero_documento',
            'sexo',
            'fecha_afiliacion',
            'afiliados.fecha_nacimiento',
            'edad_cumplida',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.correo2',
            'direccion_residencia_cargue',
            'direccion_residencia_numero_exterior',
            'direccion_residencia_via',
            'direccion_residencia_numero_interior',
            'direccion_residencia_interior',
            'direccion_residencia_barrio',
            'afiliados.discapacidad',
            'grado_discapacidad',
            'parentesco',
            'tipo_documento_cotizante',
            'numero_documento_cotizante',
            'tipo_cotizante',
            'categorizacion',
            'nivel',
            'sede_odontologica',
            'subregion_id',
            'departamento_afiliacion_id',
            'municipio_afiliacion_id',
            'departamento_atencion_id',
            'municipio_atencion_id',
            'medico_familia1_id',
            'medico_familia2_id',
            'afiliados.user_id',
            'estado_afiliacion_id',
            'tipo_afiliacion_id',
            'dpto_residencia_id',
            'notificacion_sms',
            'mpio_residencia_id',
            'afiliados.entidad_id as afiliado_entidad_id',
            'afiliados.created_at',
            'afiliados.updated_at',
            'reps.nombre as ips',
            'entidades.id as entidad_id',
            'afiliados.tipo_afiliado_id',
            'afiliados.ips_id',
            'reps.nombre as nombreRep',
            'reps.direccion as repDireccion',
            'reps.telefono1 as telefono1rep',
            'reps.telefono2 as telefono2rep'
        )
            ->leftJoin('reps', 'afiliados.ips_id', '=', 'reps.id')
            ->join('entidades', 'afiliados.entidad_id', '=', 'entidades.id')
            ->leftJoin('users', 'users.id', '=', 'afiliados.medico_familia1_id')
            ->with([
                'tipoDocumento:id,nombre',
                'entidad:id,nombre',
                'tipo_afiliacion:id,nombre',
                'TipoAfiliado:id,nombre',
                'EstadoAfiliado:id,nombre',
                'departamento_atencion:id,nombre',
                'municipio_atencion:id,nombre',
                'medico.operador',
                'medico2.operador',
                'colegios:id,nombre',
                'ips:id,nombre'
            ])
            ->where('numero_documento', $numero_documento)
            ->where('tipo_documento', $tipo_documento)
            ->whereIn('estado_afiliacion_id', [1, 32, 33])
            ->first();

        return $afiliado;
    }

    /**
     * Consultar afiliado por cédula y tipo de documento.
     *
     * @param string $cedula
     * @param string $tipoDocumento
     * @return mixed
     */
    public function consultarAfiliado($cedula, $tipoDocumento)
    {
        return $this->afiliadoModel
            ->where('numero_documento', $cedula)
            ->where('tipo_documento', $tipoDocumento)
            ->with([
                'clasificacion:id,nombre',
                'ips:id,nombre',
                'tipoDocumento:id,nombre',
                'entidad:id,nombre',
                'EstadoAfiliado:id,nombre',
                'TipoAfiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'municipio_atencion:id,nombre,codigo_dane',
                'departamento_atencion:id,nombre,codigo_dane',
                'medico.operador',
                'medico2.operador',
                'colegios:id,nombre'
            ])
            ->firstOrFail();
    }

    /**
     * Consultar afiliado cotizante por documento.
     * @author Manuela
     * @param string $documento
     * @return mixed
     */
    public function consultarAfiliadoDocumento($documento)
    {
        return $this->afiliadoModel
            ->where('numero_documento', $documento)
            ->with([
                'clasificacion:id,nombre',
                'ips:id,nombre',
                'tipoDocumento:id,nombre',
                'entidad:id,nombre',
                'EstadoAfiliado:id,nombre',
                'TipoAfiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'municipio_atencion:id,nombre,codigo_dane',
                'departamento_atencion:id,nombre,codigo_dane',
                'medico.operador',
                'medico2.operador',
                'colegios:id,nombre'
            ])
            ->first();
    }

    /**
     * Listar beneficiarios de un cotizante por id.
     * @author Manuela
     * @param string $documento_afiliado
     * @return mixed
     */
    public function listarBeneficiariosPorDoc(string $documento_afiliado)
    {
        return $this->afiliadoModel
            ->where('numero_documento_cotizante', $documento_afiliado)
            ->get();
    }


    /**
     * Listar el grupo familiar de un afiliado.
     *
     * @param object $data
     * @return mixed
     */
    public function listarGrupoFamiliar($data)
    {
        $grupoCotizante = $this->afiliadoModel->where('numero_documento_cotizante', $data->numero_documento)
            ->with(['EstadoAfiliado', 'tipoDocumento', 'TipoAfiliado']);

        if ($grupoCotizante->count() === 0) {
            $grupoBeneficiario = $this->afiliadoModel->where('numero_documento', $data->numero_documento_cotizante)
                ->with(['EstadoAfiliado', 'tipoDocumento', 'TipoAfiliado']);
            return $data->page ? $grupoBeneficiario->paginate($data->cant) : $grupoBeneficiario->get();
        }

        return $data->page ? $grupoCotizante->paginate($data->cant) : $grupoCotizante->get();
    }



    /**
     * Generar reporte de red de afiliados.
     *
     * @return mixed
     */
    public function reporteRedAfiliados()
    {
        return $this->afiliadoModel->where('ips_id', Auth::id())->get();
    }

    /**
     * Obtener datos por ID de consulta.
     *
     * @param int $consulta_id
     * @return mixed
     */
    public function obtenerDatosPorConsulta($consulta_id)
    {
        return $this->afiliadoModel->WhereConsulta($consulta_id)->first();
    }

    /**
     * Actualizar los datos de un paciente y registrar los cambios.
     *
     * @param Request $request
     * @return mixed
     */
    public function actualizacionPacientes(Request $request)
    {
        $afiliado = Afiliado::where('numero_documento', $request['numero_documento'])->first();
        $cambios = [];

        // Obtener los nombres correspondientes de acuerdo a los id
        $ipsAnterior = Rep::find($afiliado->ips_id)->nombre ?? 'Desconocido';
        $ipsNuevo = Rep::find($request['ips_id'])->nombre ?? 'Desconocido';

        $departamentoAnterior = Departamento::find($afiliado->departamento_atencion_id)->nombre ?? 'Desconocido';
        $departamentoNuevo = Departamento::find($request['departamento_atencion_id'])->nombre ?? 'Desconocido';

        $municipioAnterior = Municipio::find($afiliado->municipio_atencion_id)->nombre ?? 'Desconocido';
        $municipioNuevo = Municipio::find($request['municipio_atencion_id'])->nombre ?? 'Desconocido';

        // Comparar valores y registrar cambios
        foreach ($request->all() as $key => $value) {
            if ($key == 'ips_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo IPS cambió de '{$ipsAnterior}' a '{$ipsNuevo}'";
            } elseif ($key == 'departamento_atencion_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo Departamento de Atención cambió de '{$departamentoAnterior}' a '{$departamentoNuevo}'";
            } elseif ($key == 'municipio_atencion_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo Municipio de Atención cambió de '{$municipioAnterior}' a '{$municipioNuevo}'";
            } elseif ($afiliado->$key != $value) {
                $cambios[] = "El campo $key cambió de '{$afiliado->$key}' a '$value'";
            }
        }

        // Verificar si la contraseña no está vacía
        if (!empty($request['contrasena'])) {
            $request['contrasena'] = bcrypt($request['contrasena']);
            $usuario = User::find($request->user_id);
            $usuario->update(['password' => $request['contrasena']]);
        }

        // Actualizar otros campos del afiliado
        $afiliado->update([
            'telefono' => $request['telefono'],
            'celular1' => $request['celular1'],
            'celular2' => $request['celular2'],
            'correo1' => $request['correo1'],
            'correo2' => $request['correo2'],
            'direccion_residencia_barrio' => $request['direccion_residencia_barrio'],
            'direccion_residencia_cargue' => $request['direccion_residencia_cargue'],
            'direccion_residencia_numero_exterior' => $request['direccion_residencia_numero_exterior'],
            'direccion_residencia_via' => $request['direccion_residencia_via'],
            'direccion_residencia_numero_interior' => $request['direccion_residencia_numero_interior'],
            'direccion_residencia_interior' => $request['direccion_residencia_interior'],
            'ips_id' => $request['ips_id'],
            'departamento_atencion_id' => $request['departamento_atencion_id'],
            'municipio_atencion_id' => $request['municipio_atencion_id'],
        ]);

        // Crear registro de novedad
        $motivoNovedad = count($cambios) > 0 ? 'Se actualizaron los siguientes campos: ' . implode(', ', $cambios) : 'No hay cambios';

        $novedadDatos = [
            'fecha_novedad' => Carbon::now(),
            'motivo' => $motivoNovedad,
            'tipo_novedad_afiliados_id' => 4,
            'user_id' => Auth()->user()->id,
            'afiliado_id' => $afiliado->id
        ];

        $this->novedadAfiliadoRepository->crearNovedad($novedadDatos);
        return $afiliado;
    }

    /**
     * Actualizar los datos de un paciente desde la web y registrar los cambios.
     *
     * @param Request $request
     * @return mixed
     */
    public function actualizacionPacientesWeb(Request $request)
    {
        $afiliado = Afiliado::where('user_id', $request['user_id'])->first();
        $cambios = [];

        // Obtener los nombres correspondientes a los IDs para IPS, Departamento y Municipio.
        // dd($afiliado);
        $ipsAnterior = Rep::find($afiliado->ips_id)->nombre ?? 'Desconocido';
        $ipsNuevo = Rep::find($request['ips_id'])->nombre ?? 'Desconocido';

        $departamentoAnterior = Departamento::find($afiliado->departamento_atencion_id)->nombre ?? 'Desconocido';
        $departamentoNuevo = Departamento::find($request['departamento_atencion_id'])->nombre ?? 'Desconocido';

        $municipioAnterior = Municipio::find($afiliado->municipio_atencion_id)->nombre ?? 'Desconocido';
        $municipioNuevo = Municipio::find($request['municipio_atencion_id'])->nombre ?? 'Desconocido';

        // Comparar los valores actuales del afiliado con los nuevos valores proporcionados en la solicitud.
        foreach ($request->all() as $key => $value) {
            if ($key == 'ips_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo IPS cambió de '{$ipsAnterior}' a '{$ipsNuevo}'";
            } elseif ($key == 'departamento_atencion_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo Departamento de Atención cambió de '{$departamentoAnterior}' a '{$departamentoNuevo}'";
            } elseif ($key == 'municipio_atencion_id' && $afiliado->$key != $value) {
                $cambios[] = "El campo Municipio de Atención cambió de '{$municipioAnterior}' a '{$municipioNuevo}'";
            } elseif ($afiliado->$key != $value) {
                $cambios[] = "El campo $key cambió de '{$afiliado->$key}' a '$value'";
            }
        }

        // Si se proporcionó una nueva contraseña, encriptarla y actualizarla en la base de datos.
        if (!empty($request['contrasena'])) {
            $request['contrasena'] = bcrypt($request['contrasena']);
            $usuario = User::find($request->user_id);
            $usuario->update(['password' => $request['contrasena']]);
        }

        // Actualizar los demás campos del afiliado en la base de datos.
        $afiliado->update([
            'telefono' => $request['telefono'],
            'celular1' => $request['celular1'],
            'celular2' => $request['celular2'],
            'correo1' => $request['correo1'],
            'correo2' => $request['correo2'],
            'direccion_residencia_barrio' => $request['direccion_residencia_barrio'],
            'direccion_residencia_cargue' => $request['direccion_residencia_cargue'],
            'direccion_residencia_numero_exterior' => $request['direccion_residencia_numero_exterior'],
            'direccion_residencia_via' => $request['direccion_residencia_via'],
            'direccion_residencia_numero_interior' => $request['direccion_residencia_numero_interior'],
            'ips_id' => $request['ips_id'],
            'colegio_id' => $afiliado->tipo_afiliado_id != 1 ? $request['colegio_id'] : null,
            'departamento_atencion_id' => $request['departamento_atencion_id'],
            'municipio_atencion_id' => $request['municipio_atencion_id'],
            'estrato' => $request['estrato'],
            'nivel_educativo' => $request['nivel_educativo'],
            'ocupacion' => $request['ocupacion'],
            'estado_civil' => $request['estado_civil'],
            'discapacidad' => $request['discapacidad'],
            'grado_discapacidad' => $request['grado_discapacidad'],
            'etnia' => $request['etnia'],
            'nombre_acompanante' => $request['nombre_acompanante'],
            'telefono_acompanante' => $request['telefono_acompanante'],
            'nombre_responsable' => $request['nombre_responsable'],
            'telefono_responsable' => $request['telefono_responsable'],
            'parentesco_responsable' => $request['parentesco_responsable'],
        ]);

        // Crear registro de novedad
        $motivoNovedad = count($cambios) > 0 ? 'Se actualizaron los siguientes campos: ' . implode(', ', $cambios) : 'No hay cambios';

        $novedadDatos = [
            'fecha_novedad' => Carbon::now(),
            'motivo' => $motivoNovedad,
            'tipo_novedad_afiliados_id' => 4,
            'user_id' => Auth()->user()->id,
            'afiliado_id' => $afiliado->id
        ];

        $this->novedadAfiliadoRepository->crearNovedad($novedadDatos);
        return $afiliado;
    }

    /**
     * Obtener datos completos de un afiliado por su ID.
     *
     * @param int $id_afiliado
     * @return mixed
     */
    public function obtenerDatosAfiliadoPorIdCompleto($id_afiliado)
    {
        return $this->afiliadoModel->find($id_afiliado);
    }

    /**
     * Crear o actualizar la caracterización de un afiliado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function crearOActualizarCaracterizacion(Request $request)
    {
        $caracterizacionExistente = CaracterizacionAfiliado::where('afiliado_id', $request->input('afiliado_id'))->first();

        if ($caracterizacionExistente) {
            $caracterizacionExistente->update($request->all());
            $this->syncCaracterizacionRelaciones($request, $caracterizacionExistente);
            return response()->json(['message' => 'Caracterización actualizada con éxito', 'caracterizacion' => $caracterizacionExistente], 200);
        } else {
            $nuevaCaracterizacion = CaracterizacionAfiliado::create($request->all());
            $this->syncCaracterizacionRelaciones($request, $nuevaCaracterizacion);
            return response()->json(['message' => 'Caracterización creada con éxito', 'caracterizacion' => $nuevaCaracterizacion], 201);
        }
    }

    /**
     * Sincronizar las relaciones de una caracterización de afiliado.
     *
     * @param Request $request
     * @param CaracterizacionAfiliado $caracterizacion
     * @return void
     */
    private function syncCaracterizacionRelaciones(Request $request, CaracterizacionAfiliado $caracterizacion)
    {
        if ($request->has('opcionesCuidadoSalud')) {
            $opcionesCuidadoSalud = json_decode($request->input('opcionesCuidadoSalud'), true);
            $caracterizacion->practica()->sync($opcionesCuidadoSalud);
        }

        if ($request->has('cancer_propio')) {
            $cancerPropio = json_decode($request->input('cancer_propio'), true);
            $caracterizacion->tipoCancerPropio()->sync($cancerPropio);
        }

        if ($request->has('cancer_familia')) {
            $cancerFamilia = json_decode($request->input('cancer_familia'), true);
            $caracterizacion->tipoCancerFamilia()->sync($cancerFamilia);
        }

        if ($request->has('metabolica_propia')) {
            $metabolicaPropia = json_decode($request->input('metabolica_propia'), true);
            $caracterizacion->tipoMetabolicaPropio()->sync($metabolicaPropia);
        }

        if ($request->has('metabolica_familia')) {
            $metabolicaFamilia = json_decode($request->input('metabolica_familia'), true);
            $caracterizacion->tipoMetabolicaFamilia()->sync($metabolicaFamilia);
        }

        if ($request->has('rcv_propia')) {
            $rcvPropia = json_decode($request->input('rcv_propia'), true);
            $caracterizacion->tipoRCV()->sync($rcvPropia);
        }

        if ($request->has('respiratoria_propia')) {
            $respiratoriaPropia = json_decode($request->input('respiratoria_propia'), true);
            $caracterizacion->tipoRespiratoria()->sync($respiratoriaPropia);
        }

        if ($request->has('inmunodeficiencia_propia')) {
            $inmunodeficienciaPropia = json_decode($request->input('inmunodeficiencia_propia'), true);
            $caracterizacion->tipoInmunodeficiencia()->sync($inmunodeficienciaPropia);
        }

        if ($request->has('condicionesRiesgo')) {
            $condicionesRiesgo = json_decode($request->input('condicionesRiesgo'), true);
            $caracterizacion->condicionRiesgo()->sync($condicionesRiesgo);
        }

        if ($request->has('rutaAtencionIntegral')) {
            $rutaAtencionIntegral = json_decode($request->input('rutaAtencionIntegral'), true);
            $caracterizacion->rutaPromocion()->sync($rutaAtencionIntegral);
        }
    }

    /**
     * Buscar un afiliado por número y tipo de documento, incluyendo la caracterización.
     *
     * @param string $numDoc
     * @param string $tipoDoc
     * @return mixed
     */
    public function buscarAfiliadoCaracterizacion($numDoc, $tipoDoc)
    {
        return Afiliado::with([
            'EstadoAfiliado',
            'entidad',
            'tipoDocumento',
            'departamento_atencion',
            'municipio_atencion',
            'tipo_afiliacion',
            'ips',
            'tipo_afiliado',
            'caracterizacionAfiliado:id,afiliado_id,estratificacion_riesgo,grupo_riesgo,user_gestor_id,user_enfermeria_id',
            'caracterizacionAfiliado.usuarioGestor.operador',
            'caracterizacionAfiliado.usuarioEnfermeria.operador',
            'caracterizacionAfiliado.practica',
            'caracterizacionAfiliado.tipoCancerPropio',
            'caracterizacionAfiliado.tipoCancerFamilia',
            'caracterizacionAfiliado.tipoMetabolicaPropio',
            'caracterizacionAfiliado.tipoMetabolicaFamilia',
            'caracterizacionAfiliado.tipoRCV',
            'caracterizacionAfiliado.tipoRespiratoria',
            'caracterizacionAfiliado.tipoInmunodeficiencia',
            'caracterizacionAfiliado.condicionRiesgo',
            'caracterizacionAfiliado.rutaPromocion',
        ])
            ->where('numero_documento', $numDoc)
            ->where('tipo_documento', $tipoDoc)
            ->first();
    }

    /**
     * Registrar un beneficiario de un afiliado.
     *
     * @param Request $request
     * @return Afiliado
     */
    public function registrarBeneficiario(Request $request)
    {
        $cotizante = Afiliado::find($request["afiliado"]["id"]);

        $dataUser = $request["beneficiario"][0];

        // Crear usuario para el beneficiario
        $nuevoUser = User::create([
            'password' => bcrypt($dataUser['numero_documento']),
            'email' => $dataUser['numero_documento'] . '@sumimedical.com',
            'tipo_usuario_id' => 2,
            'reps_id' => $cotizante->ips_id,
            'estaActivo' => true,
        ]);

        // Determinar la región y el sexo del beneficiario
        $region = Georeferenciacion::where('municipio_id', $dataUser['municipio_afiliacion_id'])->value('zona');
        $sexo = $dataUser['sexo'] === 'Masculino' ? 'M' : ($dataUser['sexo'] === 'Femenino' ? 'F' : null);

        // Crear beneficiario
        return Afiliado::create([
            'region' => $region,
            'primer_nombre' => strtoupper($dataUser['primer_nombre']),
            'segundo_nombre' => strtoupper($dataUser['segundo_nombre']),
            'primer_apellido' => strtoupper($dataUser['primer_apellido']),
            'segundo_apellido' => strtoupper($dataUser['segundo_apellido']),
            'tipo_documento' => $dataUser['tipo_documento_id'],
            'numero_documento' => $dataUser['numero_documento'],
            'sexo' => $sexo,
            'fecha_afiliacion' => Carbon::now(),
            'fecha_nacimiento' => $dataUser['fecha_nacimiento'],
            'telefono' => $dataUser['telefono'],
            'celular1' => $dataUser['celular1'],
            'celular2' => $dataUser['celular2'],
            'correo1' => $dataUser['correo1'],
            'correo2' => $dataUser['correo2'],
            'direccion_residencia_cargue' => $dataUser['direccion_residencia_cargue'],
            'direccion_residencia_numero_exterior' => $dataUser['direccion_residencia_numero_exterior'],
            'direccion_residencia_numero_interior' => $dataUser['direccion_residencia_primer_interior'],
            'direccion_residencia_interior' => $dataUser['direccion_residencia_interior'],
            'direccion_residencia_barrio' => $dataUser['direccion_residencia_barrio'],
            'discapacidad' => $dataUser['discapacidad'],
            'grado_discapacidad' => $dataUser['grado_discapacidad'],
            'parentesco' => $dataUser['parentesco'],
            'tipo_documento_cotizante' => $cotizante->tipo_documento,
            'numero_documento_cotizante' => $cotizante->numero_documento,
            'tipo_cotizante' => $cotizante->tipo_cotizante,
            'departamento_afiliacion_id' => $dataUser['departamento_afiliacion_id'],
            'municipio_afiliacion_id' => $dataUser['municipio_afiliacion_id'],
            'departamento_atencion_id' => $dataUser['departamento_atencion_id'],
            'municipio_atencion_id' => $dataUser['municipio_atencion_id'],
            'ips_id' => $cotizante->ips_id,
            'user_id' => $nuevoUser->id,
            'estado_afiliacion_id' => 1,
            'tipo_afiliacion_id' => $dataUser['tipo_afiliacion_id'],
            'dpto_residencia_id' => $dataUser['departamento_afiliacion_id'],
            'mpio_residencia_id' => $dataUser['municipio_afiliacion_id'],
            'asegurador_id' => 1,
            'entidad_id' => $dataUser['entidad_id'],
            'tipo_afiliado_id' => $dataUser['tipo_afiliado_id'],
            'pais_id' => $dataUser['pais_id'],
        ]);
    }

    public function actualizarDatosContacto($afiliadoId, $request)
    {
        $afiliado = Afiliado::findOrFail($afiliadoId);

        // Guardar los valores anteriores manualmente
        $valoresAntiguos = [
            'telefono' => $afiliado->telefono,
            'celular1' => $afiliado->celular1,
            'celular2' => $afiliado->celular2,
            'correo1' => $afiliado->correo1,
            'correo2' => $afiliado->correo2,
            'direccion_residencia_cargue' => $afiliado->direccion_residencia_cargue,
            'direccion_residencia_via' => $afiliado->direccion_residencia_via,
            'direccion_residencia_numero_interior' => $afiliado->direccion_residencia_numero_interior,
            'direccion_residencia_interior' => $afiliado->direccion_residencia_interior,
            'direccion_residencia_numero_exterior' => $afiliado->direccion_residencia_numero_exterior,
            'direccion_residencia_barrio' => $afiliado->direccion_residencia_barrio,
            'departamento' => $afiliado->departamento_residencia->nombre ?? '',
            'municipio' => $afiliado->municipio_residencia->nombre ?? '',
            'nombre_responsable' => $afiliado->nombre_responsable,
            'telefono_responsable' => $afiliado->telefono_responsable,
            'parentesco_responsable' => $afiliado->parentesco_responsable
        ];

        // Obtener los IDs actuales del departamento y municipio
        $departamentoIdActual = $afiliado->dpto_residencia_id;
        $municipioIdActual = $afiliado->mpio_residencia_id;

        // Actualizar los datos del afiliado
        $afiliado->update([
            'telefono' => $request['telefono'],
            'celular1' => $request['celular1'],
            'celular2' => $request['celular2'],
            'correo1' => $request['correo1'],
            'correo2' => $request['correo2'],
            'direccion_residencia_cargue' => $request['direccion_residencia_cargue'],
            'direccion_residencia_via' => $request['direccion_residencia_via'],
            'direccion_residencia_numero_interior' => $request['direccion_residencia_numero_interior'],
            'direccion_residencia_interior' => $request['direccion_residencia_interior'],
            'direccion_residencia_numero_exterior' => $request['direccion_residencia_numero_exterior'],
            'direccion_residencia_barrio' => $request['direccion_residencia_barrio'],
            'dpto_residencia_id' => $request['dpto_residencia_id'],
            'mpio_residencia_id' => $request['mpio_residencia_id'],
            'nombre_responsable' => $request['nombre_responsable'],
            'telefono_responsable' => $request['telefono_responsable'],
            'parentesco_responsable' => $request['parentesco_responsable'],
        ]);

        // Verificar si el departamento o municipio han cambiado
        $nombreDepartamentoNuevo = '';
        $nombreMunicipioNuevo = '';

        if ($departamentoIdActual != $request['dpto_residencia_id']) {
            $nombreDepartamentoNuevo = Departamento::find($request['dpto_residencia_id'])->nombre ?? '';
        } else {
            $nombreDepartamentoNuevo = $valoresAntiguos['departamento'];
        }

        if ($municipioIdActual != $request['mpio_residencia_id']) {
            $nombreMunicipioNuevo = Municipio::find($request['mpio_residencia_id'])->nombre ?? '';
        } else {
            $nombreMunicipioNuevo = $valoresAntiguos['municipio'];
        }

        // Crear manualmente el array de valores nuevos
        $valoresNuevos = [
            'telefono' => $request['telefono'],
            'celular1' => $request['celular1'],
            'celular2' => $request['celular2'],
            'correo1' => $request['correo1'],
            'correo2' => $request['correo2'],
            'direccion_residencia_cargue' => $request['direccion_residencia_cargue'],
            'direccion_residencia_via' => $request['direccion_residencia_via'],
            'direccion_residencia_numero_interior' => $request['direccion_residencia_numero_interior'],
            'direccion_residencia_interior' => $request['direccion_residencia_interior'],
            'direccion_residencia_numero_exterior' => $request['direccion_residencia_numero_exterior'],
            'direccion_residencia_barrio' => $request['direccion_residencia_barrio'],
            'departamento' => $nombreDepartamentoNuevo,
            'municipio' => $nombreMunicipioNuevo,
            'nombre_responsable' => $request['nombre_responsable'],
            'telefono_responsable' => $request['telefono_responsable'],
            'parentesco_responsable' => $request['parentesco_responsable'],
        ];

        // Comparar los valores antiguos con los nuevos
        $cambios = [];
        foreach ($valoresAntiguos as $campo => $valorAntiguo) {
            $nuevoValor = $valoresNuevos[$campo];
            if ($valorAntiguo != $nuevoValor) {
                $cambios[] = "El campo '$campo' cambió de '$valorAntiguo' a '$nuevoValor'";
            }
        }

        // Construir el motivo de la novedad
        $motivo = 'Actualización de datos de contacto: ' . implode(', ', $cambios);

        // Crear la novedad
        $dataNovedad = [
            'fecha_novedad' => Carbon::now(),
            'motivo' => $motivo,
            'tipo_novedad_afiliados_id' => 4,
            'user_id' => auth()->user()->id,
            'afiliado_id' => $afiliadoId
        ];

        $this->novedadAfiliadoRepository->crearNovedad($dataNovedad);

        return response()->json('Datos de contacto actualizados exitosamente', 200);
    }


    /**
     * Busca el Afiliado por su ID y actualiza sus datos, además de crear una novedad.
     * @param mixed $afiliadoId ID del afiliado
     * @param mixed $data Datos a actualizar
     * @return Collection
     */
    public function actualizarAfiliado($afiliadoId, $data)
    {
        // Obtener el afiliado por ID
        $afiliado = Afiliado::find($afiliadoId);

        // Campos a actualizar
        $campos = [
            'tipo_documento' => 'Tipo de Documento',
            'numero_documento' => 'Número de Documento',
            'primer_nombre' => 'Primer Nombre',
            'segundo_nombre' => 'Segundo Nombre',
            'primer_apellido' => 'Primer Apellido',
            'segundo_apellido' => 'Segundo Apellido',
            'entidad_id' => 'Entidad',
            'sexo' => 'Sexo',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'fecha_afiliacion' => 'Fecha de Afiliación',
            'tipo_afiliacion_id' => 'Tipo de Afiliación',
            'tipo_afiliado_id' => 'Tipo de Afiliado',
            'estado_afiliacion_id' => 'Estado de Afiliación',
            'grupo_sanguineo' => 'Grupo Sanguíneo',
            'nivel_educativo' => 'Nivel Académico',
            'ocupacion' => 'Ocupación',
            'estado_civil' => 'Estado Civil',
            'orientacion_sexual' => 'Orientación Sexual',
            'identidad_genero' => 'Identidad de Género',
            'discapacidad' => 'Discapacidad',
            'grado_discapacidad' => 'Grado de Discapacidad',
            'salario_minimo_afiliado' => 'Rango Salarial',
            'pais_id' => 'Nacionalidad',
            'departamento_afiliacion_id' => 'Departamento de Afiliación',
            'municipio_afiliacion_id' => 'Municipio de Afiliación',
            'departamento_atencion_id' => 'Departamento de Atención',
            'municipio_atencion_id' => 'Municipio de Atención',
            'dpto_residencia_id' => 'Departamento de Residencia',
            'mpio_residencia_id' => 'Municipio de Residencia',
            'ips_id' => 'IPS Primaria',
            'medico_familia1_id' => 'Médico de Familia 1',
            'medico_familia2_id' => 'Médico de Familia 2',
            'region' => 'Región',
            'telefono' => 'Teléfono',
            'celular1' => 'Celular Principal',
            'celular2' => 'Celular Secundario',
            'correo1' => 'Correo Principal',
            'correo2' => 'Correo Secundario',
            'direccion_residencia_cargue' => 'Dirección de Residencia - Cargue',
            'direccion_residencia_via' => 'Dirección de Residencia - Vía',
            'direccion_residencia_numero_interior' => 'Dirección de Residencia - Número Interior',
            'direccion_residencia_interior' => 'Dirección de Residencia - Interior',
            'direccion_residencia_numero_exterior' => 'Dirección de Residencia - Número Exterior',
            'direccion_residencia_barrio' => 'Dirección de Residencia - Barrio',
            'colegio_id' => 'Colegio',
            'parentesco' => 'Parentesco',
            'tipo_documento_cotizante' => 'Tipo documento cotizante',
            'numero_documento_cotizante' => 'Número documento cotizante',
            'plan' => 'Plan',
            'categoria' => 'Categoría',
            'localidad' => 'Localidad',
            'zona_vivienda' => 'Zona de Vivienda',
            'escalafon' => 'Escalafón',
            'numero_folio' => 'Número de Folio',
            'fecha_folio' => 'Fecha del Folio',
            'cuidad_orden_judicial' => 'Ciudad de Orden Judicial',
            'user_id' => 'ID de Usuario',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'fecha_expedicion_documento' => 'Fecha de Expedición del Documento',
            'fecha_vigencia_documento' => 'Fecha de Vigencia del Documento',
            'fecha_defuncion' => 'Fecha de Defunción',
            'tipo_documento_padre_beneficiario' => 'Tipo de Documento del Padre o Beneficiario',
            'edad_cumplida' => 'Edad Cumplida',
            'subregion_id' => 'ID de Subregión',
            'municipio_nacimiento_id' => 'ID de Municipio de Nacimiento',
            'fecha_posible_parto' => 'Fecha Posible de Parto',
            'asegurador_id' => 'ID de Asegurador',
            'id' => 'ID',
            'numero_habitaciones' => 'Número de Habitaciones',
            'numero_miembros' => 'Número de Miembros',
            'acceso_vivienda' => 'Acceso a la Vivienda',
            'seguridad_vivienda' => 'Seguridad en la Vivienda',
            'vivienda' => 'Tipo de Vivienda',
            'agua_potable' => 'Disponibilidad de Agua Potable',
            'preparacion_alimentos' => 'Lugar de Preparación de Alimentos',
            'energia_electrica' => 'Disponibilidad de Energía Eléctrica',
            'donde_labora' => 'Lugar donde Labora',
            'etnia' => 'Etnia',
            'religion' => 'Religión',
            'nombre_acompanante' => 'Nombre del Acompañante',
            'telefono_acompanante' => 'Teléfono del Acompañante',
            'nombre_responsable' => 'Nombre del Responsable',
            'telefono_responsable' => 'Teléfono del Responsable',
            'parentesco_responsable' => 'Parentesco del Responsable',
            'orden_judicial' => 'Orden Judicial',
            'proferido' => 'Número Proferido',
            'ruta_adj_doc_cotizante' => 'Ruta Documento Cotizante',
            'ruta_adj_doc_beneficiario' => 'Ruta Documento Beneficiario',
            'ruta_adj_solic_firmada' => 'Ruta Solicitud Firmada',
            'ruta_adj_matrimonio' => 'Ruta Acta de Matrimonio',
            'ruta_adj_rc_nacimiento_beneficiario' => 'Ruta Registro Civil de Nacimiento Beneficiario',
            'ruta_adj_rc_nacimiento_cotizante' => 'Ruta Registro Civil de Nacimiento Cotizante',
            'ruta_adj_cert_discapacidad_hijo' => 'Ruta Certificado de Discapacidad Hijo',
            'nivel_ensenanza' => 'Nivel de Enseñanza',
            'area_ensenanza_nombrado' => 'Área de Enseñanza Nombrado',
            'cargo' => 'Cargo',
            'nombre_cargo' => 'Nombre del Cargo',
            'tipo_vinculacion' => 'Tipo de Vinculación',
            'numero_documento_padre_beneficiario' => 'Número Documento Padre o Beneficiario',
            'tipo_nombramiento' => 'Tipo de Nombramiento',
            'gestante' => 'Gestante',
            'semanas_gestacion' => 'Semanas de Gestación',
            'grupo_poblacional' => 'Grupo Poblacional',
            'victima_conflicto_armado' => 'Víctima del Conflicto Armado',
            'zona_residencia' => 'Zona de Residencia',
            'id_afiliado' => 'ID Afiliado',
            'tipo_cotizante' => 'Tipo de Cotizante',
            'categorizacion' => 'Categorización',
            'nivel' => 'Nivel',
            'sede_odontologica' => 'Sede Odontológica',
            'tipo_categoria' => 'Tipo de Categoría',
            'ciclo_vida_atencion' => 'Ciclo de Vida de Atención',
            'estrato' => 'Estrato',
            'tipo_vivienda' => 'Tipo de Vivienda',
            'exento_pago' => 'Exento de Pago',

        ];

        // Iterar sobre los campos y detectar cambios
        foreach ($campos as $campo => $nombreCampo) {
            $valorAntiguo = $afiliado->$campo;
            $valorNuevo = array_key_exists($campo, $data) ? $data[$campo] : null;

            // Obtener el nombre del valor antiguo (Aplica solo para los campos con llaves foraneas y enums)
            switch ($campo) {
                case 'tipo_documento':
                    $valorAntiguoNombre = TipoDocumento::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = TipoDocumento::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;
                case 'entidad_id':
                    $valorAntiguoNombre = Entidad::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Entidad::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'sexo':
                    $valorAntiguo = $valorAntiguo == 'M' ? 'Masculino' : 'Femenino';
                    $valorNuevo = $valorNuevo == 'M' ? 'Masculino' : 'Femenino';
                    break;

                case 'tipo_afiliacion_id':
                    $valorAntiguoNombre = TipoAfiliacion::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = TipoAfiliacion::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'tipo_afiliado_id':
                    $valorAntiguoNombre = TipoAfiliado::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = TipoAfiliado::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'estado_afiliacion_id':
                    $valorAntiguoNombre = Estado::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Estado::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'pais_id':
                    $valorAntiguoNombre = Pais::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Pais::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'departamento_afiliacion_id':
                    $valorAntiguoNombre = Departamento::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Departamento::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'municipio_afiliacion_id':
                    $valorAntiguoNombre = Municipio::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Municipio::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'departamento_atencion_id':
                    $valorAntiguoNombre = Departamento::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Departamento::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'municipio_atencion_id':
                    $valorAntiguoNombre = Municipio::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Municipio::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'dpto_residencia_id':
                    $valorAntiguoNombre = Departamento::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Departamento::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'mpio_residencia_id':
                    $valorAntiguoNombre = Municipio::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Municipio::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'ips_id':
                    $valorAntiguoNombre = Rep::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Rep::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'medico_familia1_id':
                    $valorAntiguoNombre = Operadore::find($valorAntiguo)->nombre ?? 'N/A';
                    $$valorNuevoNombre = Operadore::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'medico_familia2_id':
                    $valorAntiguoNombre = Operadore::find($valorAntiguo)->nombre ?? 'N/A';
                    $$valorNuevoNombre = Operadore::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;

                case 'colegio_id':
                    $valorAntiguoNombre = Colegio::find($valorAntiguo)->nombre ?? 'N/A';
                    $valorNuevoNombre = Colegio::find($valorNuevo)->nombre ?? 'N/A';

                    $valorAntiguo = $valorAntiguoNombre;
                    $valorNuevo = $valorNuevoNombre;
                    break;
            }

            // Verificar si el valor antiguo o nuevo son arrays, y convertirlos a string si es necesario
            if (is_array($valorAntiguo)) {
                $valorAntiguo = json_encode($valorAntiguo);
            }
            if (is_array($valorNuevo)) {
                $valorNuevo = json_encode($valorNuevo);
            }

            // Si el valor cambió, registrar la novedad
            if ($valorAntiguo != $valorNuevo) {
                novedadAfiliado::create([
                    'afiliado_id' => $afiliadoId,
                    'motivo' => "El campo {$nombreCampo} cambió de '{$valorAntiguo}' a '{$valorNuevo}'",
                    'fecha_novedad' => Carbon::now(),
                    'user_id' => auth()->user()->id,
                    'tipo_novedad_afiliados_id' => 4
                ]);
            }
        }

        // Validar si discapacidad es "Sin discapacidad" y poner grado_discapacidad como null
        if ($data['discapacidad'] === 'Sin discapacidad') {
            $data['grado_discapacidad'] = null;
        }

        // Actualizar los datos del afiliado
        // $afiliado->update($data->only(array_keys($campos)));
        $afiliado->update(Arr::only($data, array_keys($campos)));

        //Actualizar el documento en operador
        if ($afiliado->user_id) {
            $operador = Operadore::where('user_id', $afiliado->user_id)->first();
            if ($operador) {
                $operador->update(['documento' => $afiliado->numero_documento]);
            }
        }

        return $afiliado;
    }

    /**
     * Verificar si existe un afiliado con el tipo de documento y número de documento proporcionados y retorna un arreglo con los datos del afiliado si existe, o un arreglo vacío si no existe
     * @param mixed $numero_documento
     * @param mixed $tipo_documento
     * @return array
     */
    public function verificarExistencia($numero_documento, $tipo_documento)
    {
        // Buscar si existe un afiliado con el tipo de documento y número de documento proporcionados
        $afiliado = Afiliado::where('numero_documento', $numero_documento)
            ->where('tipo_documento', $tipo_documento)
            ->first();

        // Si existe, retornar true con los datos del afiliado
        if ($afiliado) {
            return [
                'res' => true,
                'mensaje' => 'Afiliado encontrado',
                'afiliado' => $afiliado
            ];
        }

        // Si no existe, retornar false
        return [
            'res' => false,
            'mensaje' => 'Afiliado no encontrado'
        ];
    }

    /**
     * Crea un registro completo de un afiliado, asociandole su usuario, entidad y rol de autogestión ademas de crear la novedad asociada a este.
     * @param mixed $data
     * @return Afiliado
     */
    public function crearAfiliadoAseguramiento($data)
    {
        DB::beginTransaction();

        $datosAfiliado = $data;

        try {

            // 1. Crear el nuevo usario asociado al afiliado
            $nuevoUsuario = User::create([
                'password' => bcrypt($datosAfiliado['numero_documento']),
                'email' => $datosAfiliado['numero_documento'] . '@sumimedical.com',
                'tipo_usuario_id' => 2,
                'reps_id' => $datosAfiliado['ips_id'],
                'estaActivo' => true,
            ]);

            // 2. Crear el nuevo afiliado y relacionarlo con el nuevo usuario
            $nuevoAfiliado = Afiliado::create([
                'tipo_documento' => $datosAfiliado['tipo_documento'],
                'numero_documento' => $datosAfiliado['numero_documento'],
                'primer_nombre' => strtoupper($datosAfiliado['primer_nombre']),
                'segundo_nombre' => strtoupper($datosAfiliado['segundo_nombre']),
                'primer_apellido' => strtoupper($datosAfiliado['primer_apellido']),
                'segundo_apellido' => strtoupper($datosAfiliado['segundo_apellido']),
                'entidad_id' => $datosAfiliado['entidad_id'],
                'sexo' => $datosAfiliado['sexo'],
                'fecha_nacimiento' => $datosAfiliado['fecha_nacimiento'],
                'fecha_afiliacion' => $datosAfiliado['fecha_afiliacion'],
                'tipo_afiliado_id' => $datosAfiliado['tipo_afiliado_id'],
                'tipo_afiliacion_id' => $datosAfiliado['tipo_afiliacion_id'],
                'estado_afiliacion_id' => $datosAfiliado['estado_afiliacion_id'],
                'grupo_sanguineo' => $datosAfiliado['grupo_sanguineo'],
                'nivel_educativo' => $datosAfiliado['nivel_educativo'],
                'ocupacion' => $datosAfiliado['ocupacion'],
                'estado_civil' => $datosAfiliado['estado_civil'],
                'orientacion_sexual' => $datosAfiliado['orientacion_sexual'],
                'identidad_genero' => $datosAfiliado['identidad_genero'],
                'discapacidad' => $datosAfiliado['discapacidad'],
                'grado_discapacidad' => $datosAfiliado['grado_discapacidad'],
                'salario_minimo_afiliado' => $datosAfiliado['salario_minimo_afiliado'],
                'pais_id' => $datosAfiliado['pais_id'],
                'departamento_afiliacion_id' => $datosAfiliado['departamento_afiliacion_id'],
                'municipio_afiliacion_id' => $datosAfiliado['municipio_afiliacion_id'],
                'departamento_atencion_id' => $datosAfiliado['departamento_atencion_id'],
                'municipio_atencion_id' => $datosAfiliado['municipio_atencion_id'],
                'dpto_residencia_id' => $datosAfiliado['dpto_residencia_id'],
                'mpio_residencia_id' => $datosAfiliado['mpio_residencia_id'],
                'region' => $datosAfiliado['region'],
                'ips_id' => $datosAfiliado['ips_id'],
                'medico_familia1_id' => $datosAfiliado['medico_familia1_id'],
                'medico_familia2_id' => $datosAfiliado['medico_familia2_id'],
                'telefono' => $datosAfiliado['telefono'],
                'celular1' => $datosAfiliado['celular1'],
                'celular2' => $datosAfiliado['celular2'],
                'correo1' => $datosAfiliado['correo1'],
                'correo2' => $datosAfiliado['correo2'],
                'direccion_residencia_cargue' => $datosAfiliado['direccion_residencia_cargue'],
                'direccion_residencia_via' => $datosAfiliado['direccion_residencia_via'],
                'direccion_residencia_numero_interior' => $datosAfiliado['direccion_residencia_numero_interior'],
                'direccion_residencia_interior' => $datosAfiliado['direccion_residencia_interior'],
                'direccion_residencia_numero_exterior' => $datosAfiliado['direccion_residencia_numero_exterior'],
                'direccion_residencia_barrio' => $datosAfiliado['direccion_residencia_barrio'],
                'colegio_id' => $datosAfiliado['colegio_id'],
                'user_id' => $nuevoUsuario->id,
                'parentesco' => $datosAfiliado['parentesco'],
                'tipo_documento_cotizante' => $datosAfiliado['tipo_documento_cotizante'],
                'numero_documento_cotizante' => $datosAfiliado['numero_documento_cotizante'],
                'plan' => $datosAfiliado['plan'],
                'categoria' => $datosAfiliado['categoria'],
            ]);


            // 3. Crear la novedad con la creacion del afiliado
            novedadAfiliado::create([
                'afiliado_id' => $nuevoAfiliado->id,
                'motivo' => "Creación de Afiliado",
                'fecha_novedad' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'tipo_novedad_afiliados_id' => 1
            ]);


            //  4. Asignar el rol de Autogestión al nuevo afiliado
            DB::table('model_has_roles')->insert([
                'role_id' => 96,
                'model_type' => 'App\Http\Modules\Usuarios\Models\User',
                'model_id' => $nuevoUsuario->id,
            ]);

            // 5. Asignar la entidad al afiliado
            DB::table('entidad_users')->insert([
                'user_id' => $nuevoUsuario->id,
                'entidad_id' => $datosAfiliado['entidad_id']
            ]);

            DB::commit();

            return $nuevoAfiliado;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Relanzar el error para ser manejado en el controlador
        }
    }

    public function actualizarAdmision($id, $data)
    {
        $this->afiliadoModel::find($id)->update([
            'telefono' => $data['telefono'],
            'celular1' => $data['celular1'],
            'celular2' => $data['celular2'],
            'direccion_residencia_cargue' => $data['direccion_residencia_cargue'],
            'direccion_residencia_barrio' => $data['direccion_residencia_barrio'],
            'correo1' => $data['correo1'],
            'correo2' => $data['correo2'],
            'nombre_responsable' => $data['nombre_responsable'],
            'telefono_responsable' => $data['telefono_responsable'],
            'parentesco_responsable' => $data['parentesco_responsable'],
        ]);
    }

    public function guardarAfiliadoAdmision($data)
    {

        DB::beginTransaction();

        try {
            // 1. Crear el nuevo usario asociado al afiliado
            $data['user_id'] = null;
            if ($data['tipo_documento'] != 15) {
                $nuevoUsuario = User::create([
                    'password' => bcrypt($data['numero_documento']),
                    'email' => $data['numero_documento'] . '@sumimedical.com',
                    'tipo_usuario_id' => 2,
                    'reps_id' => $data['ips_id'],
                    'estaActivo' => true,
                ]);
                $data['user_id'] = $nuevoUsuario->id;
            }

            // 2 se crea el usuario
            $afiliado = $this->afiliadoModel::create($data);

            //3 se crea la novedad
            $this->novedadAfiliadoRepository->guardarNovedadAdmision($afiliado->id);

            DB::commit();
            return $afiliado;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Lista un afiliado por su id
     * @param int $afiliadoId
     * @return Afiliado|null
     * @author Thomas
     */
    public function listarAfiliadoPorId(int $afiliadoId): ?Afiliado
    {
        return $this->afiliadoModel
            ->with([
                'clasificacion:id,nombre',
                'ips:id,nombre',
                'tipoDocumento:id,nombre',
                'entidad:id,nombre',
                'EstadoAfiliado:id,nombre',
                'TipoAfiliado:id,nombre',
                'tipo_afiliacion:id,nombre',
                'municipio_atencion:id,nombre,codigo_dane',
                'departamento_atencion:id,nombre,codigo_dane',
                'medico.operador',
                'medico2.operador',
                'colegios',
                'colegios.municipio',
                'colegios.municipio.departamento',
            ])
            ->findOrFail($afiliadoId);
    }

    public function buscarAfiliadoTipoNumeroDocumento(int $tipoDocumento, string $numeroDocumento): ?Afiliado
    {
        return $this->afiliadoModel
            ->where('tipo_documento', $tipoDocumento)
            ->where('numero_documento', $numeroDocumento)
            ->first();
    }

    /**
     * Busca un afiliado por ID
     * @param int $afiliadoId
     * @return Afiliado
     * @author Thomas
     */
    public function buscarAfiliadoPorId(int $afiliadoId): Afiliado
    {
        return $this->afiliadoModel->findOrFail($afiliadoId);
    }

    /**
     * Busca un afiliado activo por tipo de documento y número de documento
     * @param string $tipoDocumento
     * @param string $numeroDocumento
     * @return Afiliado
     * @author Thomas
     */
    public function buscarAfiliadoActivoPorDocumento(string $tipoDocumento, string $numeroDocumento): ?Afiliado
    {
        return Afiliado::where('tipo_documento', $tipoDocumento)
            ->where('numero_documento', $numeroDocumento)
            ->where('estado_afiliacion_id', 1)
            ->first();
    }


    public function verificarEstado(string $cedula, string $tipo_documento): ?object
    {
        return $this->afiliadoModel
            ->where('numero_documento', $cedula)
            ->where('tipo_documento', $tipo_documento)
            ->select(
                'estado_afiliacion_id',
                'tipo_afiliado_id',
                'primer_nombre',
                'segundo_nombre',
                'primer_apellido',
                'segundo_apellido'
            )
            ->first();
    }


    public function buscarPorNombreYFecha(
        string $primer_nombre,
        string $segundo_nombre,
        string $primer_apellido,
        string $segundo_apellido,
        string $fecha_nacimiento
    ): ?Afiliado {
        return Afiliado::buscarPorNombreYFecha(
            $primer_nombre,
            $segundo_nombre,
            $primer_apellido,
            $segundo_apellido,
            $fecha_nacimiento
        )->first();
    }

    public function obtenerPosiblesConyuges(string $numeroDocumento): Collection
    {
        return Afiliado::select('id', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'parentesco')
            ->where('numero_documento_cotizante', trim($numeroDocumento))
            ->where('tipo_afiliado_id', 1)
            ->get();
    }

    /**
     * Obtiene un afiliado por su ID, incluyendo relaciones con TipoAfiliado y clasificacion.
     * @param int $afiliadoId
     * @return Afiliado|null
     */
    public function getAfiliadoById(int $afiliadoId)
    {
        return Afiliado::with('TipoAfiliado', 'clasificacion')->find($afiliadoId);
    }
}
