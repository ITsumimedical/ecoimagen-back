<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Movimientos\Controllers\MovimientoController;

Route::prefix('movimientos')->group(function () {
    Route::controller(MovimientoController::class)->group(function () {
        Route::post('guardar/{tipo}', 'guardar');
        Route::get('listarDispensacion/{ordenArticuloId}', 'listarDispensacion');
        Route::get('verificar-existencia-factura/{factura}', 'verificarExistenciFactura');
        Route::post('consignacion', 'entradaConsignacion');
        Route::post('guardarFirma/{movimiento_id}','guardarFirmaRecibe');
    });
});
