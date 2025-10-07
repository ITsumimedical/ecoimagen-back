<?php

use App\Http\Modules\HijosEmpleados\Controllers\HijoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('hijo-empleado', 'throttle:60,1')->group(function () {
    Route::controller(HijoEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:hijoEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:hijoEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:hijoEmpleado.actualizar');
    });
});
