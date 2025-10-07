<?php

use App\Http\Modules\Pqrsf\AreasPqrsf\Controllers\AreasPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('areas-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(AreasPqrsfController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listarAreas', 'listarAreas');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizar', 'actualizar');
        Route::post('actualizarAreas/{pqrsfId}', 'actualizarAreas');
        Route::post('removerArea/{pqrsfId}', 'removerArea');
    });
});
