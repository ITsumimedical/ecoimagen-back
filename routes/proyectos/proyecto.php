<?php

use App\Http\Modules\Proyectos\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

Route::prefix('proyectos')->group( function () {
    Route::controller(ProyectoController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:proyecto.listar');
        Route::post('crear','crear');//->middleware('permission:proyecto.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:proyecto.actualizar');
    });
});
