<?php

namespace App\Http\Modules\PortabilidadEntrada\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Http\Modules\PortabilidadEntrada\Models\portabilidadEntrada;

class PortabilidadEntradaRepository extends RepositoryBase
{
    protected $portabilidadModel;
    protected $novedadAfiliadoRepository;

    public function __construct(NovedadAfiliadoRepository $novedadAfiliadoRepository)
    {
        $this->portabilidadModel = new portabilidadEntrada();
        parent::__construct($this->portabilidadModel);
        $this->novedadAfiliadoRepository = $novedadAfiliadoRepository;
    }

    public function crearNuevaPortabilidadEntrada($request)
    {
        return $this->portabilidadModel->create([
            'origen_ips' => $request['origen_ips'],
            'telefono_ips' => $request['telefono_ips'],
            'correo_ips' => $request['correo_ips'],
            'fecha_inicio' => $request['fecha_inicio'],
            'fecha_final' => $request['fecha_final'],
            'cantidad_dias' => $request['cantidad_dias'],
            'user_id' => Auth()->user()->id,

        ]);
    }

    public function listarPortabilidadEntrada(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $entrada = portabilidadEntrada::select(
            'portabilidad_entradas.id',
            'portabilidad_entradas.origen_ips',
            'portabilidad_entradas.telefono_ips',
            'portabilidad_entradas.correo_ips',
            'portabilidad_entradas.fecha_inicio',
            'portabilidad_entradas.fecha_final',
            'portabilidad_entradas.cantidad_dias',
            'novedad_afiliados.fecha_novedad',
            'afiliados.numero_documento',
            'afiliados.id as afiliado_id',
            'afiliados.sexo',
            'afiliados.fecha_nacimiento',
            'afiliados.fecha_afiliacion',
            'afiliados.parentesco',
            'afiliados.numero_documento_cotizante',
            'afiliados.tipo_cotizante',
            'afiliados.estado_afiliacion_id',
            'afiliados.discapacidad',
            'afiliados.departamento_atencion_id',
            'afiliados.municipio_atencion_id',
            'afiliados.sede_odontologica',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.correo2',
            'municipios.nombre as municipioAtencion',
            'departamentos.nombre as departamentoAtencion',
            'estados.nombre as estado',
            'tipo_documentos.nombre as tp',
            'entidades.nombre as entidad',
            'departamentos.nombre as departamentoAfiliacion',
            'departamentos.codigo_dane as DaneDepartamento',
            'municipios.nombre as municipioAfiliacion',
            'municipios.codigo_dane as DaneMunicipio',
            'subregiones.nombre as subregion',
            DB::raw("CONCAT(empleados1.primer_nombre, ' ', empleados1.segundo_nombre, ' ', empleados1.primer_apellido, ' ', empleados1.segundo_apellido) as medico_familia1"),
            DB::raw("CONCAT(empleados2.primer_nombre, ' ', empleados2.segundo_nombre, ' ', empleados2.primer_apellido, ' ', empleados2.segundo_apellido) as medico_familia2"),
            'reps.nombre as ips'
        )
            ->join('novedad_afiliados', 'novedad_afiliados.portabilidad_entrada_id', 'portabilidad_entradas.id')
            ->where('novedad_afiliados.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('novedad_afiliados')
                    ->whereColumn('novedad_afiliados.portabilidad_entrada_id', 'portabilidad_entradas.id');
            })
            ->join('afiliados', 'novedad_afiliados.afiliado_id', 'afiliados.id')
            ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->join('estados', 'afiliados.estado_afiliacion_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->join('subregiones', 'afiliados.subregion_id', 'subregiones.id')
            ->join('reps', 'afiliados.ips_id', 'reps.id')
            ->leftjoin('users as users1', 'afiliados.medico_familia1_id', 'users1.id')
            ->leftjoin('users as users2', 'afiliados.medico_familia2_id', 'users2.id')
            ->leftjoin('empleados as empleados1', 'empleados1.user_id', 'users1.id')
            ->leftjoin('empleados as empleados2', 'empleados2.user_id', 'users2.id')
            ->orderBy('portabilidad_entradas.id', 'asc')
            ->where('portabilidad_entradas.estado_id', 1)
            ->selectRaw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_completo");

        if ($request->documento) {
            $entrada->where('afiliados.numero_documento', 'ILIKE', '%' . $request->documento . '%');
        }

        if ($request->nombre_afiliado) {
            $entrada->orwhere('afiliados.primer_nombre', 'ILIKE', '%' . $request->nombre_afiliado . '%');
            $entrada->orwhere('afiliados.segundo_nombre', 'ILIKE', '%' . $request->nombre_afiliado . '%');
            $entrada->orwhere('afiliados.primer_apellido', 'ILIKE', '%' . $request->nombre_afiliado . '%');
            $entrada->orwhere('afiliados.segundo_apellido', 'ILIKE', '%' . $request->nombre_afiliado . '%');
        }

        if ($request->entidad) {
            $entrada->where('origen_ips', 'ILIKE', '%' . $request->entidad . '%');
        }

        if ($request->has('page')) {
            return $entrada->paginate($cantidad);
        } else {
            return $entrada->get();
        }
    }

    public function InactivarPortabilidadEntrada($id)
    {
        $inactivar = $this->portabilidadModel->find($id);

        if (!$inactivar) {
            return response()->json(['message' => 'portabilidad de entrada no encontrada'], 404);
        }

        if ($inactivar->estado_id == 2) {
            return response()->json(['message' => 'La portabilidad de entrada ya se encuentra inactiva'], 400);
        }

        $inactivar->estado_id = 2;
        $inactivar->save();

        return response()->json(['message' => 'portabilidad de entrada inactivada con éxito'], 200);
    }


    public function actualizarPortabilidadEntrada($id, array $data)
    {
        $entrada = $this->portabilidadModel->findOrFail($id);

        // Obtener las fechas anteriores
        $fechaInicioAnterior = $entrada->fecha_inicio;
        $fechaFinalAnterior = $entrada->fecha_final;
        $entrada->update($data);
        $fechaInicioNuevo = $data['fecha_inicio'];
        $fechaFinalNuevo = $data['fecha_final'];

        // Crear el motivo de la novedad solo si se modifican las fechas
        if ($fechaInicioAnterior != $fechaInicioNuevo || $fechaFinalAnterior != $fechaFinalNuevo) {
            $motivo = 'Fechas anteriores: ' . $fechaInicioAnterior . ' - ' . $fechaFinalAnterior . ', Cambio a: ' . $fechaInicioNuevo . ' - ' . $fechaFinalNuevo;

            // Crear la nueva novedad
            $datos = [
                'fecha_novedad' => Carbon::now(),
                'motivo' => $motivo,
                'tipo_novedad_afiliados_id' => 8,
                'user_id' => Auth()->user()->id,
                'afiliado_id' => $data['afiliado_id'],
                'portabilidad_entrada_id' => $entrada->id,
            ];
            $this->novedadAfiliadoRepository->NovedadEntrada($datos);
        }
        return $entrada;
    }

    public function portabilidadEntradaNovedades($afiliado_id, $portabilidad_entrada_id)
    {
        return novedadAfiliado::where('afiliado_id', $afiliado_id)
            ->where('portabilidad_entrada_id', $portabilidad_entrada_id)
            ->with(['tipoNovedad', 'portabilidadEntrada'])
            ->join('portabilidad_entradas as pe', 'novedad_afiliados.portabilidad_entrada_id', 'pe.id')
            ->join('estados', 'pe.estado_id', 'estados.id')
            ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.segundo_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_apellido) as nombre_completo")
            ->addSelect([
                'novedad_afiliados.id',
                'fecha_novedad',
                'novedad_afiliados.motivo as Motivo',
                'novedad_afiliados.user_id',
                'users.email',
                'tipo_novedad_afiliados_id',
                'portabilidad_entrada_id',
                'estados.nombre as estado',
                'pe.cantidad_dias as cantidad'
            ])
            ->join('empleados', 'empleados.id', 'novedad_afiliados.user_id')
            ->join('users', 'users.id', 'empleados.user_id')
            ->orderBy('novedad_afiliados.id', 'asc')
            ->get();
    }

    public function verificarExistenciaPortabilidad($idUsuario, $numeroCedula)
    {
        return novedadAfiliado::where('afiliado_id', $idUsuario)
            ->whereHas('afiliado', function ($query) use ($numeroCedula) {
                $query->where('numero_documento', $numeroCedula);
            })
            ->count();
    }

    public function obtenerHistorialPortabilidad($idUsuario, $numeroCedula)
    {
        return NovedadAfiliado::whereHas('afiliado', function ($query) use ($numeroCedula) {
            $query->where('numero_documento', $numeroCedula);
        })
            ->where('afiliado_id', $idUsuario)
            ->whereNotNull('portabilidad_entrada_id')
            ->where('tipo_novedad_afiliados_id', 8)
            ->with(['portabilidadEntrada'])
            ->join('portabilidad_entradas as pe', 'novedad_afiliados.portabilidad_entrada_id', 'pe.id')
            ->join('estados', 'pe.estado_id', 'estados.id')
            ->orderBy('novedad_afiliados.id', 'asc')
            ->get([
                'novedad_afiliados.id',
                'fecha_novedad',
                'novedad_afiliados.motivo',
                'tipo_novedad_afiliados_id',
                'portabilidad_entrada_id',
                'estado_id',
                'estados.nombre as estado',
                'pe.cantidad_dias as cantidad'
            ]);
    }

    public function obtenerAfiliadoPorCedula($numeroCedula)
    {
        return Afiliado::where('numero_documento', $numeroCedula)->first();
    }

    public function verificarPortabilidadesActivas($afiliado_id)
    {
        $portabilidadesActivas = portabilidadEntrada::whereHas('novedadAfiliado', function ($query) use ($afiliado_id) {
            $query->where('afiliado_id', $afiliado_id);
        })->where('estado_id', 1)->exists();

        return $portabilidadesActivas;
    }
}
