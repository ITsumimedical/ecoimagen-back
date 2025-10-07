<?php

use App\Http\Modules\MascotasEmpleados\Controllers\MascotaEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('mascota-empleado', 'throttle:60,1')->group(function () {
    Route::controller(MascotaEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
    });
});
