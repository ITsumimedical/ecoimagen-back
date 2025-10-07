<?php

namespace App\Http\Modules\Alertas\Repositories;

use App\Http\Modules\Alertas\AlertaDetalles\Model\alertaDetalles;
use App\Http\Modules\Alertas\Models\Alertas;
use App\Http\Modules\AuditoriaAlertas\Model\auditoriaAlertas;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\PrincipiosActivos\Model\principioActivo;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AlertasRepository extends RepositoryBase
{

    protected $alertas;

    public function __construct()
    {
        $this->alertas = new Alertas();
        parent::__construct($this->alertas);
    }

    public function listarPrincipal($data)
    {
        $filas = isset($data->filas) ? $data->filas : 10;

        $consulta = Alertas::with(['usuarioRegistra.operador', 'estado'])
            ->whereNotNull('principal')
            ->whereNull('codesumi_id')
            ->orderBy('created_at');

        return isset($data->page) ? $consulta->paginate($filas) : $consulta->get();
    }

    public function crearAlertaMedicamento($data)
    {
        $alerta = Alertas::create([
            'codesumi_id' => $data['codesumi_id'],
            'estado_id' => $data['estado_id'],
            'usuario_registra_id' => $data['usuario_registra_id'],
        ]);

        alertaDetalles::create([
            'alerta_id' => $alerta->id,
            'tipo_alerta_id' => 3,
            'mensaje_alerta_id' => 1,
            'estado_id' => 1,
            'usuario_registra_id' => auth()->user()->id,
        ]);

        return $alerta;
    }



    public function listarCodesumi($data)
    {
        $filas = isset($data->filas) ? $data->filas : 10;
        $consulta =  Alertas::with(['codesumi', 'usuarioRegistra.operador', 'estado'])
            ->whereNotNull('codesumi_id')
            ->whereNull('principal_id')
            ->orderBy('created_at');
            if($data->codesumi){
                $nombre = $data->codesumi;
                $consulta->whereHas('codesumi',function($query)use($nombre){
                    $query->where('nombre','ILIKE','%'.$nombre.'%');
                });
            }
        return isset($data->page) ? $consulta->paginate($filas) : $consulta->get();
    }

    public function actualizar($id, $data)
    {
        $alerta = Alertas::find($id);
        if ($alerta) {
            $alerta->update($data);
            return $alerta;
        }

        throw new \Exception('Alerta no encontrada');
    }

    public function cambiarEstado($id)
    {
        $alerta = Alertas::find($id);
        if ($alerta) {
            if ($alerta->estado_id == 1) {
                $alerta->estado_id = 2;
            } elseif ($alerta->estado_id == 2) {
                $alerta->estado_id = 1;
            }
            $alerta->save();

            // Actualizar estado de alertas detalles asociadas
            $alertaDetalles = alertaDetalles::where('alerta_id', $id)->get();
            foreach ($alertaDetalles as $detalle) {
                $detalle->estado_id = $alerta->estado_id;
                $detalle->save();
            }

            return $alerta;
        }
        throw new \Exception('Alerta no encontrada');
    }


    /**
     * validarAlergia
     *  Se valida la interaccion de un principio activo con el codesumi y con el afiliado para validar si es alergico
     * @param  mixed $afiliadoId
     * @param  mixed $codesumiId
     * @return void
     */
    public function validarAlergia($afiliadoId, $codesumiId)
    {
        // Verificar si existe una intersección entre los principios activos alérgicos y los del medicamento
        $hayAlergia = AntecedentesFarmacologico::whereHas('consulta.afiliado', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })
        ->whereHas('principioActivo', function ($query) use ($codesumiId) {
            $query->whereNotIn('id',[14])
            ->whereHas('codesumi', function ($query2) use ($codesumiId) {
                $query2->where('codesumi_id', $codesumiId);
            });
        })
            ->exists();

        if ($hayAlergia) {
            throw new Error("El afiliado es alérgico a uno o más principios activos del medicamento.", 400);
        }

        return true;
    }

    public function verificarInteraccionEntreMedicamentos(array $medicamentosSeleccionados)
    {
        // Buscar los principios activos de los medicamentos seleccionados
        $principiosActivos = Codesumi::whereIn('id', $medicamentosSeleccionados)
            ->pluck('principio_activo');

        // Buscar en la tabla de alertas si alguno de los principios activos tiene un valor en el campo principal
        $alertasConPrincipal = Alertas::whereIn('principal', $principiosActivos)
            ->get();

        if ($alertasConPrincipal->isEmpty()) {
            // Si no se encuentra ningún medicamento con principal, no hay interacción
            return [
                'resultado' => false
            ];
        }

        // Ahora, iterar sobre las alertas con principal y verificar interacciones en alerta_detalles
        $interacciones = [];

        foreach ($alertasConPrincipal as $alerta) {
            // Buscar en alerta_detalles si el medicamento principal tiene interacciones con alguno de los otros principios activos seleccionados
            $detallesInteraccion = alertaDetalles::where('alerta_id', $alerta->id)
                ->with('mensajeAlerta', 'tipoAlerta')
                ->whereIn('interaccion', $principiosActivos)
                ->where('estado_id', 1)
                ->get();

            if (!$detallesInteraccion->isEmpty()) {
                foreach ($detallesInteraccion as $detalle) {
                    $interacciones[] = [
                        'id' => $detalle->id,  // Incluyendo el ID de alertaDetalle
                        'tipo_alerta' => $detalle->tipoAlerta->nombre,
                        'mensaje' => $detalle->mensajeAlerta->mensaje,
                    ];
                }
            }
        }

        if (!empty($interacciones)) {
            return [
                'resultado' => true,
                'interacciones' => $interacciones
            ];
        }

        return ['resultado' => false];
    }


    public function desabastecimiento(Request $request)
    {
        //Verificar primero que el medicamento no sea null
        if ($request->medicamento['id'] != null) {
            $alergico = Alertas::select('mensajes_alertas.mensaje', 'tipo_alertas.nombre as tipo_alerta', 'alerta_detalles.id as alertaDetalleId')
                ->join('alerta_detalles', 'alerta_detalles.alerta_id', 'alertas.id')
                ->join('mensajes_alertas', 'mensajes_alertas.id', 'alerta_detalles.mensaje_alerta_id')
                ->join('tipo_alertas', 'tipo_alertas.id', 'alerta_detalles.tipo_alerta_id')
                ->where('alerta_detalles.estado_id', 1)
                ->where('alertas.codesumi_id', $request->medicamento['id'])->first();

            if ($alergico == null) {
                $alergico = false;
            }
        } else {
            $alergico = false;
        }
        return $alergico;
    }

    public function crearAuditoria(Request $request)
    {
        auditoriaAlertas::create($request->all());
    }

    /**
     * Lista todas la consulta para seguimiento alertas con sus relaciones, 
     * se pagina por tener que buscar datos de muchas tablas
     * @param array $paginacion
     * @return LengthAwarePaginator
     * @modifiedBy jose vasquez
     */
    public function listarAuditoriaAlertas(array $paginacion): LengthAwarePaginator
    {

        $paginacion = $paginacion['paginacion'];

        $auditoria = auditoriaAlertas::select(
            'auditoria_alertas.acepto',
            'auditoria_alertas.alerta_detalle_id',
            'auditoria_alertas.usuario_registra_id',
            'auditoria_alertas.consulta_id',
            'auditoria_alertas.estado_alerta_id',
            'auditoria_alertas.created_at',
            'estados.nombre as estadoAlerta',
            'users.email as UserCrea',
            'afiliados.numero_documento',
            DB::raw("CONCAT(afiliados.primer_nombre, ' ', afiliados.primer_apellido) as nombreAfiliado"),
            DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as NombreOperador"),
            'tipo_alertas.nombre as TipoAlerta',
            'mensajes_alertas.titulo',
            'mensajes_alertas.mensaje as mensajeAlerta',
            'alertas.principal',
            'alerta_detalles.interaccion',
        )
            ->join('users', 'auditoria_alertas.usuario_registra_id', 'users.id')
            ->join('operadores', 'operadores.user_id', 'users.id')
            ->join('estados', 'auditoria_alertas.estado_alerta_id', 'estados.id')
            ->join('consultas', 'auditoria_alertas.consulta_id', 'consultas.id')
            ->join('afiliados', 'consultas.afiliado_id', 'afiliados.id')
            ->join('alerta_detalles', 'auditoria_alertas.alerta_detalle_id', 'alerta_detalles.id')
            ->join('tipo_alertas', 'alerta_detalles.tipo_alerta_id', 'tipo_alertas.id')
            ->join('mensajes_alertas', 'alerta_detalles.mensaje_alerta_id', 'mensajes_alertas.id')
            ->join('alertas', 'alerta_detalles.alerta_id', 'alertas.id')
            ->orderBy('auditoria_alertas.id', 'desc');

        return $auditoria->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

    }
}
