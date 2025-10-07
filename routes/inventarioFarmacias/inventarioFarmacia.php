<?php

use App\Http\Modules\InventarioFarmacia\Controllers\InventarioFarmaciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventario-farmacia', 'throttle:60,1')->group(function () {
    Route::controller(InventarioFarmaciaController::class)->group(function() {
        Route::post('registrarInventario','registrarInventario');//->middleware(['permission:turno.guardar']);
        Route::get('inventarioActivo','inventarioActivo');//->middleware(['permission:turno.guardar']);
        Route::get('detalle-inventario/{id}','detalleInventarioActivo');
        Route::post('finalizar-conteo-1','finalizarConteo1');
        Route::post('finalizar-conteo-2','finalizarConteo2');
        Route::post('finalizar-conteo-3','finalizarConteo3');
        Route::put('finalizar-inventario/{id}','finalizarInventario');
        Route::post('guardar-progreso/{id}','guardarProgreso');
        Route::get('medicamentos-bodega/{bodega}/{medicamento}','medicamentosBodega');
        Route::get('buscar-lotes/{inventario}/{id}','buscarLotes0');
        Route::post('agregar-lote/{id}','agregarLote');
        Route::get('inventarios','inventarios');
        Route::get('reporte-detalle/{id}','reporteDetalle');
    });
});
