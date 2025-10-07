<?php

namespace App\Http\Modules\Bodegas\Services;

use App\Http\Modules\Bodegas\Models\Bodega;

class BodegaService{


    /**
     * Listar todas las bodegas
     *
     * Este método devuelve una lista de todas las bodegas, incluyendo información adicional
     * sobre el estado, tipo de bodega y municipio asociados. Los datos se obtienen mediante
     * la combinación (join) de las tablas relacionadas.
     *
     * @throws \Throwable Si ocurre algún error durante la ejecución
     *
     * @version 1.0.0
     * @since 2024-07-30
     *
     * @author
     *  - kobatime
     */
    public function listarTodasBodegas() {
        return Bodega::select(
            'bodegas.id',
            'bodegas.municipio_id',
            'bodegas.tipo_bodega_id',
            'bodegas.cobertura',
            'bodegas.tiempo_reposicion',
            'bodegas.stock_seguridad',
            'bodegas.hora_fin',
            'bodegas.hora_inicio',
            'bodegas.telefono',
            'bodegas.direccion',
            'bodegas.updated_at',
            'bodegas.created_at',
            'bodegas.estado_id',
            'bodegas.nombre',
            'estados.nombre as estadoNombre',
            'municipios.nombre as nombreMUnicipio')
            ->with('tipoBodega:id,id as tipo_bodega_id,nombre')
            ->leftjoin('municipios','municipios.id','bodegas.municipio_id')
            ->leftjoin('estados','estados.id','bodegas.estado_id')
            ->get();
    }

    public function buscarUnaBodega($bodega_id) {
        return Bodega::select(
            'bodegas.id',
            'bodegas.municipio_id',
            'bodegas.tipo_bodega_id',
            'bodegas.cobertura',
            'bodegas.tiempo_reposicion',
            'bodegas.stock_seguridad',
            'bodegas.hora_fin',
            'bodegas.hora_inicio',
            'bodegas.telefono',
            'bodegas.direccion',
            'bodegas.updated_at',
            'bodegas.created_at',
            'bodegas.estado_id',
            'bodegas.nombre',
            'reps.nombre as rep',
            'bodegas.ferrocarriles',
            'estados.nombre as estadoNombre')
            ->with('tipoBodega:id,id as tipo_bodega_id,nombre','municipio:id,id as municipio_id,nombre')
            ->leftjoin('estados','estados.id','bodegas.estado_id')
            ->leftjoin('reps', 'bodegas.rep_id', 'reps.id')
            ->where('bodegas.id',$bodega_id)
            ->first();
    }

    public function buscarUsuariosBodega($bodega_id)
    {
    return Bodega::with([
        'user.operador.cargo'
    ])
    ->where('bodegas.id', $bodega_id)
    ->select('id')
    ->get();
    }

    public function eliminarUserBodega(int $bodegaId, array $userIds): bool
    {
        // Encontrar la bodega por su ID
        $bodega = Bodega::find($bodegaId);
        if (!$bodega) {
            return false;
        }

        // Eliminar la relación entre la bodega y los usuarios
        $bodega->user()->detach($userIds);
        return true;
    }



}
