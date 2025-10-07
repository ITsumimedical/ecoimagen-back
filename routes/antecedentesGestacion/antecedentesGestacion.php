<?php

use App\Http\Modules\AntecedentesGestacion\Controller\AntecedeGestacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentesGestacion', 'throttle:60,1')->group(function () {
    Route::controller(AntecedeGestacionController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
        Route::delete('eliminar/{id}', 'eliminar');

    });
});
