<?php

use App\Http\Modules\Cargos\Controllers\CargoController;
use Illuminate\Support\Facades\Route;

Route::prefix('cargo', 'throttle:60,1')->group(function () {
    Route::controller(CargoController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:cargos.listar');
        Route::post('crear', 'crear');//->middleware('permission:cargos.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:cargos.actualizar');
        Route::get('exportar', 'exportar');
        Route::get('listarTodos', 'listarTodos');
    });
});
