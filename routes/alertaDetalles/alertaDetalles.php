<?php

use App\Http\Modules\Alertas\AlertaDetalles\Controllers\AlertaDetalleController;
use Illuminate\Support\Facades\Route;

Route::prefix('alertas-detalles')->group(function () {
    Route::controller(AlertaDetalleController::class)->group(function () {
        Route::post('crearAlertaDetalle','crearAlertaDetalle');
        Route::get('historialAlerta/{id}','historialAlerta');
        Route::put('cambiarEstado/{id}', 'cambiarEstado');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
