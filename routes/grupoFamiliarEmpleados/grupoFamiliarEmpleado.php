<?php

use App\Http\Modules\GrupoFamiliarEmpleados\Controllers\GrupoFamiliarEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('grupo-familiar-empleado', 'throttle:60,1')->group(function () {
    Route::controller(GrupoFamiliarEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:grupoFamiliarEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:grupoFamiliarEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:grupoFamiliarEmpleado.actualizar');
    });
});
