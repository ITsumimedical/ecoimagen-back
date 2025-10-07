<?php

use App\Http\Modules\Codesumis\lineasBases\Controllers\lineasBasesController;
use App\Http\Modules\LogsKeiron\Controllers\logsKeironController;
use Illuminate\Support\Facades\Route;

Route::prefix('logs-keiron')->group(function () {
    Route::controller(logsKeironController::class)->group(function () {
        Route::get('envio-masivo-consulta', 'envioMasivoConsulta');
        Route::post('cambiar-estado-keiron/{consultaId}', 'cambiarEstadoKeiron');
        Route::post('envio-masivo-canceladas', 'envioMasivoCanceladas');
    });

});
