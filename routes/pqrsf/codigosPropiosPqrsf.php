<?php

use App\Http\Modules\Pqrsf\CodigosPropios\Controller\CodigoPropioPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('codigos-propios-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(CodigoPropioPqrsfController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::post('crear', 'crear');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizarCodigosPropios/{pqrsfId}', 'actualizarCodigosPropios');
        Route::post('removerCodigoPropio/{pqrsfId}', 'removerCodigoPropio');
    });
});
