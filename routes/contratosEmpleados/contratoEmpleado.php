<?php

use App\Http\Modules\ContratosEmpleados\Controllers\ContratoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('contrato-empleado', 'throttle:60,1')->group(function () {
    Route::controller(ContratoEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:contratoEmpleado.listar');
        Route::post('cierreMes', 'cierreMes');//->middleware('permission:contratoEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:contratoEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:contratoEmpleado.actualizar');
        Route::put('terminar/{id}', 'terminar');//->middleware('permission:contratoEmpleado.terminarContrato');
    });
});
