<?php

use App\Http\Modules\Prioridades\Controllers\PrioridadControllers;
use Illuminate\Support\Facades\Route;

Route::prefix('prioridades')->group( function () {
    Route::controller(PrioridadControllers::class)->group(function (){
        Route::get('listar-prioridades','listar');//->middleware('permission:prioridad.listar');
        Route::post('crear','crear'); //->middleware('permission:prioridad.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:prioridad.actualizar');
        Route::get('/consultar/{id}','consultar');//->middleware('permission:prioridad.listar');
    });
});
