<?php

use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Controllers\EmpleadosPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('empleado-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(EmpleadosPqrsfController::class)->group(function () {
        Route::post('listarEmpleados', 'listarEmpleados');
        Route::post('crear', 'crear');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizarOperadores/{pqrsfId}', 'actualizarOperadores');
        Route::post('removerOperador/{pqrsfId}', 'removerOperador');
    });
});
