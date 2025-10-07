<?php

use App\Http\Modules\EstudiosEmpleados\Controllers\EstudioEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('estudio-empleado', 'throttle:60,1')->group(function () {
    Route::controller(EstudioEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:estudioEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:estudioEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:estudioEmpleado.actualizar');
    });
});
