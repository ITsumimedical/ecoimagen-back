<?php

use App\Http\Modules\HistoricoContratoEmpleado\Controllers\HistoricoContratoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('historico-contrato-empleado', 'throttle:60,1')->group(function () {
    Route::controller(HistoricoContratoEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:contratoEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:contratoEmpleado.crear');
    });
});
