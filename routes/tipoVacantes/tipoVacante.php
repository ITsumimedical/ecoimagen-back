<?php

use App\Http\Modules\TipoVacantesTH\Controllers\TipoVacanteThController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-vacantesTh','throttle:60,1')->group(function () {
    Route::controller(TipoVacanteThController::class)->group(function () {
        Route::post('listar', 'listar')         ;//->middleware(['permission:tipoVacante.listar']);
        Route::post('crear', 'crear')           ;//->middleware(['permission:tipoVacante.crear']);
        Route::put('editar/{id}', 'actualizar') ;//->middleware(['permission:tipoVacante.actualizar']);
    });
});

