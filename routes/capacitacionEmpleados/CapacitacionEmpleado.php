<?php

use App\Http\Modules\CapacitacionEmpleados\Controllers\CapacitacionEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('capacitacion-empleado', 'throttle:60,1')->group(function () {
    Route::controller(CapacitacionEmpleadoController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:capacitacionEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:capacitacionEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:capacitacionEmpleado.actualizar');
    });
});
