<?php

use App\Http\Modules\Medicamentos\Controllers\BodegaMedicamentoController;
use Illuminate\Support\Facades\Route;

Route::prefix('bodega-medicamentos', 'throttle:60,1')->group(function () {
    Route::controller(BodegaMedicamentoController::class)->group(function () {
        Route::post('consultar', 'consultar');
        Route::put('actualizarLote/{id}', 'actualizarLote');
        Route::post('inventario','inventario');
        Route::post('exportar','exportar');
        Route::post('buscarLote','buscarLote');
        Route::post('buscarLoteMedicamentoEntrada','buscarLoteMedicamentoEntrada');
        Route::post('buscarLoteMedicamentoSalida','buscarLoteMedicamentoSalida');
        Route::get('lotesDispensacion/{bodega}/{articulo}','loteDisponibleDispensacion');
        Route::post('listar', 'listar');
        Route::post('guardar','guardar');
        Route::get('bodegaEntrada/{bodega_id}','bodegaEntrada');
        Route::get('bodegaSalida/{bodega_id}','bodegaSalida');
        Route::post('consultarTraslados', 'consultarTraslados');
        Route::post('inactivar','inactivar');
    });
});
