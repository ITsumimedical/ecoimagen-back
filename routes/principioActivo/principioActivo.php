<?php

use App\Http\Modules\PrincipiosActivos\Controller\principioActivoController;
use Illuminate\Support\Facades\Route;

Route::prefix('principios-activos', 'throttle:60,1')->group(function () {
    Route::controller(principioActivoController::class)->group(function () {
        Route::post('crearPrincipio', 'crear');
        Route::get('listar', 'listar');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
