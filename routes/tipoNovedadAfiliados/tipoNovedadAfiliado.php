<?php

use App\Http\Modules\TiposNovedadAfiliados\Controllers\TipoNovedadAfiliadosController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-novedad-afiliado', 'throttle:60,1')->group(function () {
    Route::controller(TipoNovedadAfiliadosController::class)->group(function () {
        Route::get('/', 'listar')                     ;//->middleware('permission:tipo.novedad.afiliado.listar');
        Route::post('crear', 'crear')                 ;//->middleware('permission:tipo.novedad.afiliado.crear');
        Route::put('/{id}', 'actualizar')             ;//->middleware('permission:tipo.novedad.afiliado.actualizar');
        Route::put('estado/{id}', 'actualizarEstado') ;//->middleware('permission:tipo.novedad.afiliado.actualizar');
    });
});
