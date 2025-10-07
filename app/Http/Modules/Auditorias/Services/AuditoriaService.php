<?php

namespace App\Http\Modules\Auditorias\Services;

use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditoriaService
{
    /**
     * Gestiona la auditoría de servicios.
     * @param array $data
     * @return bool
     * @throws \Throwable
     * @author Thomas
     */
    public function gestionarAuditoriaServicios(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $userId = Auth::id();
            $ordenProcedimientos = $data['orden_procedimientos'];
            $nuevoEstado = $data['estado'];
            $observacion = $data['observacion'];
            $timestamp = now();
            $posFechar = $data['pos_fechar'];
            $fechaVigencia = $data['fecha_vigencia'];

            // Obtener solo los IDs de las órdenes de procedimientos
            $ordenProcedimientosIds = OrdenProcedimiento::whereIn('id', $ordenProcedimientos)->pluck('id');

            // Actualizar el estado en todas las órdenes de una sola vez
            OrdenProcedimiento::whereIn('id', $ordenProcedimientosIds)->update(['estado_id' => $nuevoEstado]);

            // Solo actualizar la fecha de vigencia si se posfecha
            if ($posFechar) {
                OrdenProcedimiento::whereIn('id', $ordenProcedimientosIds)->update(['fecha_vigencia' => $fechaVigencia]);
            }

            // Preparar auditorías para inserción masiva
            $auditorias = $ordenProcedimientosIds->map(fn($id) => [
                'orden_procedimiento_id' => $id,
                'user_id' => $userId,
                'observaciones' => $observacion,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ])->toArray();

            // Insertar auditorías en una sola consulta
            Auditoria::insert($auditorias);

            return true;
        });
    }

    public function gestionarAuditoriaCodigosPropios(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $userId = Auth::id();
            $ordenCodigosPropios = $data['orden_codigos_propios'];
            $nuevoEstado = $data['estado'];
            $observacion = $data['observacion'];
            $timestamp = now();
            $posFechar = $data['pos_fechar'];
            $fechaVigencia = $data['fecha_vigencia'];

            // Obtener solo los IDs de las órdenes de procedimientos
            $ordenCodigosPropiosIds = OrdenCodigoPropio::whereIn('id', $ordenCodigosPropios)->pluck('id');

            // Actualizar el estado en todas las órdenes de una sola vez
            OrdenCodigoPropio::whereIn('id', $ordenCodigosPropiosIds)->update(['estado_id' => $nuevoEstado]);

            // Solo actualizar la fecha de vigencia si se posfecha
            if ($posFechar) {
                OrdenCodigoPropio::whereIn('id', $ordenCodigosPropiosIds)->update(['fecha_vigencia' => $fechaVigencia]);
            }

            // Preparar auditorías para inserción masiva
            $auditorias = $ordenCodigosPropiosIds->map(fn($id) => [
                'orden_codigo_propio_id' => $id,
                'user_id' => $userId,
                'observaciones' => $observacion,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ])->toArray();

            // Insertar auditorías en una sola consulta
            Auditoria::insert($auditorias);

            return true;
        });
    }

    /**
     * Gestiona la auditoría de medicamentos.
     * @param array $data
     * @return bool
     * @throws \Throwable
     * @author Thomas
     */
    public function gestionarAuditoriaMedicamentos(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $userId = Auth::id();
            $ordenArticulos = $data['orden_articulos'];
            $nuevoEstado = $data['estado'];
            $observacion = $data['observacion'];
            $createdAt = now();
            $updatedAt = now();
            $negar = $data['negar'];
            $fundamentoLegal = $data['fundamento_legal'];
            $alternativas = $data['alternativas_acceso_salud'];
            $tipoPlanUsuario = $data['tipo_plan_usuario'];

            $ordenes = OrdenArticulo::whereIn('id', $ordenArticulos)->get(['id', 'estado_id']);

            // Actualizar el estado de los OrdenArticulo en una sola consulta
            OrdenArticulo::whereIn('id', $ordenArticulos)->update(['estado_id' => $nuevoEstado]);

            // Insertar auditorías en la tabla Auditoria en una sola consulta
            $auditorias = $ordenes->map(function ($orden) use ($userId, $observacion, $createdAt, $updatedAt, $negar, $fundamentoLegal, $alternativas, $tipoPlanUsuario) {
                return [
                    'orden_articulo_id' => $orden->id,
                    'user_id' => $userId,
                    'observaciones' => $observacion,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'fundamento_legal' => $negar ? $fundamentoLegal : null,
                    'alternativas_acceso_salud' => $negar ? $alternativas : null,
                    'tipo_plan_usuario' => $negar ? $tipoPlanUsuario : null
                ];
            })->toArray();

            return Auditoria::insert($auditorias);
        });
    }
}
