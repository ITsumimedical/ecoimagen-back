<?php

use App\Http\Modules\IncapacidadesEmpleados\Controllers\IncapacidadEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('incapacidad-empleado', 'throttle:60,1')->group(function () {
    Route::controller(IncapacidadEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:incapacidadEmpleado.listar');
        Route::get('/listarInicial/{id}', 'listarInicial');//->middleware('permission:incapacidadEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:incapacidadEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:incapacidadEmpleado.actualizar');
    });
});
