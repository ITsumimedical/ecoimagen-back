<?php

use App\Http\Modules\Pqrsf\IpsPqrsf\Controllers\ipsPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('ips-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(ipsPqrsfController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listarIps', 'listarIps');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizarIps/{pqrsfId}', 'actualizarIps');
        Route::post('removerIps/{pqrsfId}', 'removerIps');
    });
});
