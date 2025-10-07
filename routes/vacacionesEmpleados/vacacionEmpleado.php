<?php

use App\Http\Modules\VacacionesEmpleados\Controllers\VacacionEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('vacacion-empleado', 'throttle:60,1')->group(function () {
    Route::controller(VacacionEmpleadoController::class) ->group(function () {
        Route::get('{id}', 'listar');//->middleware(['permission:vacacionEmpleado.listar']);
        Route::post('crear', 'crear');//->middleware(['permission:vacacionEmpleado.crear']);
        Route::put('/{id}', 'actualizar');//->middleware(['permission:vacacionEmpleado.actualizar']);
        Route::put('/autorizar/{vacacion}', 'autorizar');//->middleware(['permission:vacacionEmpleado.autorizar']);
        Route::put('/anular/{vacacion}', 'anular');//->middleware(['permission:vacacionEmpleado.anular']);
    });
});
