<?php

use App\Http\Modules\Estados\Controllers\EstadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('estados', 'throttle:60,1')->group(function (){
    Route::controller(EstadoController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware(['permission:listar.estados']);
        Route::post('crear', 'crear');//->middleware(['permission:crear.estado']);
        Route::put('/{id}', 'actualizar');//->middleware(['permission:actualizar.estado']);
    });
});
