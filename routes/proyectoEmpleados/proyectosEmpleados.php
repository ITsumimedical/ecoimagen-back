<?php

use App\Http\Modules\ProyectoEmpleado\Controllers\ProyectoEmpleadosController;
use Illuminate\Support\Facades\Route;

Route::prefix('proyecto-empleados')->group( function () {
    Route::controller(ProyectoEmpleadosController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
    });
});
