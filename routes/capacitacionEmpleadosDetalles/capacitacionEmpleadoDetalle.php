<?php

use App\Http\Modules\CapacitacionEmpleados\Controllers\CapacitacionEmpleadoDetalleController;
use Illuminate\Support\Facades\Route;

Route::prefix('capacitacion-empleado-detalle', 'throttle:60,1')->group(function () {
    Route::controller(CapacitacionEmpleadoDetalleController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:capacitacionEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:capacitacionEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:capacitacionEmpleado.actualizar');
    });
});
