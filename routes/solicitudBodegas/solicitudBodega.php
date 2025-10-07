<?php

use App\Http\Modules\SolicitudBodegas\Controllers\SolicitudBodegaController;
use Illuminate\Support\Facades\Route;

Route::prefix('solicitud-bodegas', 'throttle:60,1')->group(function () {
    Route::controller(SolicitudBodegaController::class)->group(function () {
        Route::post('crearAjusteEntrada', 'crearAjusteEntrada');
        Route::post('crearSolicitudCompra', 'crearSolicitudCompra');
        Route::get('listar/{solicitud}/{estado}/{bodega}','listar');
        Route::get('listar-detalle/{solicitud}/{bodega}','listarDetalle');
        Route::post('aprobar-solicitud','aprobarSolicitud');
        Route::post('rechazar-solicitud','rechazarSolicitud');
        Route::post('aprobar-solicitud-detalle','aprobarSolicitudDetalle');
        Route::post('aprobar-solicitud-traslado','aprobarSolicitudTraslado');
        Route::post('importarExcel','importarExcel');
        Route::post('cargaMasiva','cargaMasiva');
        Route::post('guardarAjusteEntrada','guardarAjusteEntrada');
        Route::post('obtnerAjuste','obtnerAjuste');
        Route::post('solicitudCompras','solicitudCompras');
        Route::post('guardarAjusteSalida','guardarAjusteSalida');
        Route::post('crearTraslado', 'crearTraslado');
        Route::get('listarTraslado/{solicitud}/{estado}/{bodega}','listarTraslado');
        Route::post('aprobarMovimientoTraslado','aprobarMovimientoTraslado');
        Route::post('rechazar-solicitud-traslado','rechazarSolicitudTraslado');
        Route::get('listarTrasladoPendiente/{solicitud}/{estado}','listarTrasladoPendiente');
        Route::post('carga-masiva-compras', 'cargarSolicitudesMasivas');
        Route::delete('eliminar-archivo-cargue-solicitudes', 'eliminarArchivoErrores');
    });
});
