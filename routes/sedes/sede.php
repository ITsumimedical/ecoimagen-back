<?php

use App\Http\Modules\Sedes\Controllers\SedeController;
use Illuminate\Support\Facades\Route;

Route::prefix('sede', 'throttle:60,1')->group(function () {
    Route::controller(SedeController::class)->group(function () {
        Route::get('listar', 'listar')      ;//->middleware('permission:sede.listar');
        Route::post('crear', 'crear')       ;//->middleware('permission:sede.crear');
        Route::put('/{id}', 'actualizar')   ;//->middleware('permission:sede.actualizar');
    });
});
