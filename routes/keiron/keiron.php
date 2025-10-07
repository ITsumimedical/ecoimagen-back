<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\LogsKeiron\Controllers\LogsKeironController;

Route::prefix('keiron', 'throttle:60,1')->group(function () {
    Route::controller(LogsKeironController::class)->group(function() {
        Route::patch('actualizar-consulta/{id}', 'actualizarConsulta');
    });
});
