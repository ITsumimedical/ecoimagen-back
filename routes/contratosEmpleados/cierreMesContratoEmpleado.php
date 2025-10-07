<?php

use App\Http\Modules\CierreMesContratosEmpleados\Controllers\CierreMesContratoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('cierre-mes-contrato', 'throttle:60,1')->group(function () {
    Route::controller(CierreMesContratoEmpleadoController::class)->group(function () {
        Route::get('', 'listar');//->middleware('permission:contratoEmpleado.listar');
    });
});
