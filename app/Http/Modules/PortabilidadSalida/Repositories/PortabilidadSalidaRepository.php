<?php

namespace App\Http\Modules\PortabilidadSalida\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\PortabilidadSalida\Models\portabilidadSalida;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;

class PortabilidadSalidaRepository extends RepositoryBase
{
    protected $portabilidadSalidaModel;
    protected $novedadAfiliadoRepository;

    public function __construct(NovedadAfiliadoRepository $novedadAfiliadoRepository)
    {
        $this->portabilidadSalidaModel = new portabilidadSalida();
        parent::__construct($this->portabilidadSalidaModel);
        $this->novedadAfiliadoRepository = $novedadAfiliadoRepository;
    }

    public function crearNuevaPortabilidadSalida($request)
    {
        return $this->portabilidadSalidaModel->create([
            'fecha_inicio' => $request['fechaInicio_portabilidad'],
            'fecha_final' => $request['fechaFinal_portabilidad'],
            'destino_ips' => $request['entidad'],
            'motivo' => $request['Motivo'],
            'cantidad' => $request['cantidad'],
            'departamento_receptor' => $request['departamento_atencion'],
            'municipio_receptor' => $request['municipio_atencion'],
            'user_id' => Auth()->user()->id,
        ]);
    }

    public function ListarPortabilidadSalida(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $salida = portabilidadSalida::select(
            'portabilidad_salidas.id',
            'portabilidad_salidas.fecha_inicio',
            'portabilidad_salidas.fecha_final',
            'portabilidad_salidas.destino_ips',
            'portabilidad_salidas.motivo',
            'portabilidad_salidas.departamento_receptor',
            'portabilidad_salidas.municipio_receptor',
            'portabilidad_salidas.destino_ips',
            'portabilidad_salidas.fecha_inicio',
            'portabilidad_salidas.fecha_final',
            'portabilidad_salidas.motivo',
            'portabilidad_salidas.cantidad',
            'municipios.nombre as municipio',
            'departamentos.nombre as departamento',
            'afiliados.id as afiliado_id',
            'afiliados.numero_documento',
            'afiliados.tipo_documento',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.fecha_nacimiento',
            'afiliados.sexo',
            'afiliados.region',
            'afiliados.parentesco',
            'afiliados.tipo_documento_cotizante',
            'afiliados.numero_documento_cotizante',
            'afiliados.tipo_cotizante',
            'afiliados.estado_afiliacion_id',
            'afiliados.discapacidad',
            'afiliados.grado_discapacidad',
            'estados.nombre as estado_afiliacion',
            'tipo_documentos.nombre as documento',
            'entidades.nombre as entidad',
            'reps.nombre as IpsPrimaria'
        )
            ->join('novedad_afiliados', 'novedad_afiliados.portabilidad_salida_id', 'portabilidad_salidas.id')
            ->where('novedad_afiliados.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('novedad_afiliados')
                    ->whereColumn('novedad_afiliados.portabilidad_salida_id', 'portabilidad_salidas.id');
            })
            ->join('afiliados', 'novedad_afiliados.afiliado_id', 'afiliados.id')
            ->join('reps', 'afiliados.ips_id', 'reps.id')
            ->join('estados', 'afiliados.estado_afiliacion_id', 'estados.id')
            ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->join('departamentos', 'portabilidad_salidas.departamento_receptor', 'departamentos.id')
            ->join('municipios', 'portabilidad_salidas.municipio_receptor', 'municipios.id')
            ->where('portabilidad_salidas.estado_id', 1)
            ->selectRaw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_completo");

        if ($request->documentoSalida) {
            $salida->where('afiliados.numero_documento', 'ILIKE', '%' . $request->documentoSalida . '%');
        }

        if ($request->nombre_afiliadoSalida) {
            $salida->orwhere('afiliados.primer_nombre', 'ILIKE', '%' . $request->nombre_afiliadoSalida . '%');
            $salida->orwhere('afiliados.segundo_nombre', 'ILIKE', '%' . $request->nombre_afiliadoSalida . '%');
            $salida->orwhere('afiliados.primer_apellido', 'ILIKE', '%' . $request->nombre_afiliadoSalida . '%');
            $salida->orwhere('afiliados.segundo_apellido', 'ILIKE', '%' . $request->nombre_afiliadoSalida . '%');
        }

        if ($request->entidadSalida) {
            $salida->where('destino_ips', 'ILIKE', '%' . $request->entidadSalida . '%');
        }

        if ($request->has('page')) {
            return $salida->paginate($cantidad);
        } else {
            return $salida->first();
        }
    }

    public function ListarNovedadesPorAfiliado($afiliado_id, $portabilidad_salida_id)
    {
        return NovedadAfiliado::where('afiliado_id', $afiliado_id)
            ->where('portabilidad_salida_id', $portabilidad_salida_id)
            ->with(['tipoNovedad', 'portabilidadSalida'])
            ->join('portabilidad_salidas as ps', 'novedad_afiliados.portabilidad_salida_id', 'ps.id')
            ->join('estados', 'ps.estado_id', 'estados.id')
            ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.segundo_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_apellido) as nombre_completo")
            ->addSelect([
                'novedad_afiliados.id',
                'fecha_novedad',
                'novedad_afiliados.motivo as Motivo',
                'novedad_afiliados.user_id',
                'users.email',
                'tipo_novedad_afiliados_id',
                'portabilidad_salida_id',
                'estados.nombre as estado',
                'ps.cantidad as cantidad'
            ])
            ->join('empleados', 'empleados.id', 'novedad_afiliados.user_id')
            ->join('users', 'users.id', 'empleados.user_id')
            ->orderBy('novedad_afiliados.id', 'asc')
            ->get();
    }



    public function actualizarPortabilidad($id, array $data)
    {
        $salida = $this->portabilidadSalidaModel->findOrFail($id);

        // Obtener las fechas anteriores
        $fechaInicioAnterior = $salida->fecha_inicio;
        $fechaFinalAnterior = $salida->fecha_final;
        $salida->update($data);
        $fechaInicioNuevo = $data['fecha_inicio'];
        $fechaFinalNuevo = $data['fecha_final'];

        // Crear el motivo de la novedad solo si se modifican las fechas
        if ($fechaInicioAnterior != $fechaInicioNuevo || $fechaFinalAnterior != $fechaFinalNuevo) {
            $motivo = 'Fechas anteriores: ' . $fechaInicioAnterior . ' - ' . $fechaFinalAnterior . ', Cambio a: ' . $fechaInicioNuevo . ' - ' . $fechaFinalNuevo;

            // Crear la nueva novedad
            $novedadDatos = [
                'fecha_novedad' => Carbon::now(),
                'motivo' => $motivo,
                'tipo_novedad_afiliados_id' => 5,
                'user_id' => Auth()->user()->id,
                'afiliado_id' => $data['afiliado_id'],
                'portabilidad_salida_id' => $salida->id,
            ];
            $this->novedadAfiliadoRepository->crearNovedad($novedadDatos);
        }
        return $salida;
    }

    // public function actualizarPortabilidad($id, array $data)
    // {
    //     $salida = $this->portabilidadSalidaModel->findOrFail($id);

    //     // Obtener las fechas anteriores
    //     $fechaInicioAnterior = $salida->fecha_inicio;
    //     $fechaFinalAnterior = $salida->fecha_final;

    //     // Actualizar la portabilidad de salida
    //     $salida->update($data);

    //     // Obtener las nuevas fechas
    //     $fechaInicioNuevo = $data['fecha_inicio'];
    //     $fechaFinalNuevo = $data['fecha_final'];

    //     // Crear el motivo de la novedad
    //     $motivo = 'Fechas anteriores: ' . $fechaInicioAnterior . ' - ' . $fechaFinalAnterior . ', Cambio a: ' . $fechaInicioNuevo . ' - ' . $fechaFinalNuevo;

    //     // Crear la nueva novedad
    //     $novedadDatos = [
    //         'fecha_novedad' => Carbon::now(),
    //         'motivo' => $motivo,
    //         'tipo_novedad_afiliados_id' => 5,
    //         'user_id' => Auth()->user()->id,
    //         'afiliado_id' => $data['afiliado_id'],
    //         'portabilidad_salida_id' => $salida->id,
    //     ];

    //     $this->novedadAfiliadoRepository->NovedadSalidad($novedadDatos);
    //     return $salida;
    // }

    public function InactivarPortabilidad($id)
    {
        $inactivar = $this->portabilidadSalidaModel->find($id);

        if (!$inactivar) {
            return response()->json(['message' => 'portabilidad de salida no encontrada'], 404);
        }

        if ($inactivar->estado_id == 2) {
            return response()->json(['message' => 'La portabilidad de salida ya se encuentra inactiva'], 400);
        }

        $inactivar->estado_id = 2;
        $inactivar->save();

        return response()->json(['message' => 'portabilidad de salida inactivada con éxito'], 200);
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
            ->whereNotNull('portabilidad_salida_id')
            ->where('tipo_novedad_afiliados_id', 5)
            ->with(['tipoNovedad', 'portabilidadSalida'])
            ->join('portabilidad_salidas as ps', 'novedad_afiliados.portabilidad_salida_id', 'ps.id')
            ->join('estados', 'ps.estado_id', 'estados.id')
            ->orderBy('novedad_afiliados.id', 'asc')
            ->get([
                'novedad_afiliados.id',
                'fecha_novedad',
                'novedad_afiliados.motivo',
                'tipo_novedad_afiliados_id',
                'portabilidad_salida_id',
                'estado_id',
                'estados.nombre as estado',
                'ps.cantidad as cantidad'
            ]);
    }

    public function obtenerAfiliadoPorCedula($numeroCedula)
    {
        return Afiliado::where('numero_documento', $numeroCedula)->first();
    }

    public function verificarPortabilidadesActivas($afiliado_id)
    {
        $portabilidadesActivas = portabilidadSalida::whereHas('novedadAfiliado', function ($query) use ($afiliado_id) {
            $query->where('afiliado_id', $afiliado_id);
        })->where('estado_id', 1)->exists();

        return $portabilidadesActivas;
    }
}
