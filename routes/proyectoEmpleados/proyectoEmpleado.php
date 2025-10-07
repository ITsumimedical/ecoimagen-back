<?php

use App\Http\Modules\ProyectosEmpleados\Controllers\ProyectoEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('proyectos-empleados')->group( function () {
    Route::controller(ProyectoEmpleadoController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
    });
});
