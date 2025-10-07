<?php

use App\Http\Modules\LicenciasEmpleados\Controllers\LicenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('licencias-empleados', 'throttle:60,1')->group(function () {
    Route::controller(LicenciaController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:licenciaEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:licenciaEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:licenciaEmpleado.actualizar');
    });
});
