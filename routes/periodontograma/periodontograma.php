<?php

use App\Http\Modules\Periodontograma\Controllers\periodontogramaController;
use Illuminate\Support\Facades\Route;

Route::prefix('periodontograma', 'throttle:60,1')->group(function () {
    Route::controller(periodontogramaController::class)->group(function () {
        Route::get('listarPeriodontograma/{consulta_id}', 'listarPeriodontogramas');
        Route::post('crear', 'crear');
        Route::delete('eliminar/{id}', 'eliminarPeriodontograma');
        Route::put('actualizar/{id}', 'actualizarPeriodontograma');


    });
});
