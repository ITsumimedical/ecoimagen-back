<?php

use App\Http\Modules\ContactosEmpleados\Controllers\ContactoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('contacto-empleado', 'throttle:60,1')->group(function () {
    Route::controller(ContactoEmpleadoController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:contactoEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:contactoEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:contactoEmpleado.actualizar');
    });
});
