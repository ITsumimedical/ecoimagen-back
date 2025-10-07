<?php

use App\Http\Modules\Bodegas\Controllers\BodegaController;
use Illuminate\Support\Facades\Route;

Route::prefix('bodegas', 'throttle:60,1')->group(function () {
    Route::controller(BodegaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('listar-por-estado/{estado_id?}', 'listarPorEstado');
        Route::post('inventarioBodega','inventarioBodega');
        Route::post('guardarFactura','guardarFactura');
        Route::post('articulosBodega','articulosBodega');
        Route::get('listarTipoBodega','listarTipoBodega');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');
        Route::get('listarCodesumi','listarCodesumi');
        Route::post('kardex','kardex');
        Route::post('minMax','minMax');
        Route::post('exportar','exportar');
        Route::post('detallesCodesumisReposicion','detallesCodesumisReposicion');
        Route::post('usuarioDispensa','usuarioDispensa');
        Route::post('historicoDispensado','historicoDispensado');
        Route::post('historicoDispensadoDetalle','historicoDispensadoDetalle');
        Route::put('actualizarEstado/{id}','actualizarEstado');
        Route::post('agregarPersonal','agregarPersonal');
        Route::get('listarBodegasUsuario','listarBodegasUsuario');
        Route::post('listarCodigosSumi','listarCodesumi');
        Route::get('listarTodasBodegas','listarTodasBodegas');
        Route::get('buscarBodega/{bodega_id}','buscarBodega');
        Route::get('getUsuariosBodega/{bodega_id}','getUsuariosBodega');
        Route::post('eliminarUsuarioBodega','eliminarUsuarioBodega');
        Route::get('listarBodegasAsociadas','listarBodegasAsociadas');
        Route::post('historicoDispensadoMovimientos','historicoDispensadoMovimientos');
        Route::get('historico-orden-articulos-dispensados/{orden_id}', 'historicoOrdenArticulosDispensadosPorOrden');
        Route::get('historico-movimientos-orden-articulos/{orden_articulo_id}', 'historicoMovimientosPorOrdenArticulo');
        Route::post('contador-historico-ordenes-dispensadas', 'contadorHistoricoOrdenesDispensadas');
        Route::get('listar-bodegas-asociadas-por-entidades/{entidad_id}', 'listarBodegasAsociadasPorEntidad');
    });
});
