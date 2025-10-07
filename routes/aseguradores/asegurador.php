<?php

use App\Http\Modules\Aseguradores\Controllers\AseguradorController;
use Illuminate\Support\Facades\Route;

Route::prefix('asegurador', 'throttle:60,1')->group(function () {
    Route::controller(AseguradorController::class)->group(function () {
        Route::get('', 'listar');//->middleware('permission:asegurador.listar');
        Route::post('', 'crear');//->middleware('permission:asegurador.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:asegurador.actualizar');
        Route::put('/cambiar-estado/{asegurador}','cambiarEstado');//->middleware('permission:asegurador.cambiarEstado');

    });
});
