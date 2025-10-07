<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\ContratosMedicamentos\Controllers\TarifasCumsController;

Route::prefix('tarifas-cums', 'throttle:60,1')->group(function () {
    Route::controller(TarifasCumsController::class)->group(function () {
        Route::post('crear-cum-tarifa', 'crearCumTarifa');
        Route::get('listar-cums-tarifa', 'listarCumsTarifa');
        Route::delete('eliminar-cum-tarifa/{cumTarifaId}', 'eliminarCumTarifa');
        Route::patch('cambiar-precio-cum-tarifa/{cumTarifaId}', 'cambiarPrecioCumTarifa');
        Route::post('cargue-masivo-cums-tarifa', 'cargueMasivoCumsTarifa');
    });
});
