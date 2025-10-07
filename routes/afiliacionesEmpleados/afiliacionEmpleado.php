<?php

use App\Http\Modules\AfiliacionesEmpleados\Controller\AfiliacionEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('afiliacion-empleado', 'throttle:60,1')->group(function () {
    Route::controller(AfiliacionEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:afiliacionEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:afiliacionEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:afiliacionEmpleado.actualizar');
        Route::put('/desafiliar/{afiliacion}', 'desafiliar');//->middleware('permission:afiliacionEmpleado.actualizar');
    });
});
