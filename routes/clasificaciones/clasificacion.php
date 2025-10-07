<?php

use App\Http\Modules\Clasificaciones\Controllers\ClasificacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('clasificacion', 'throttle:60,1')->group(function () {
    Route::controller(ClasificacionController::class)->group(function () {
        Route::get('/', 'listar');//->middleware('permission:clasificacion.afiliado.listar');
        Route::post('crear', 'crear');//->middleware('permission:clasificacion.afiliado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:clasificacion.afiliado.actualizar');
        Route::put('estado/{id}', 'actualizarEstado');//->middleware('permission:clasificacion.afiliado.actualizar');
    });
});
