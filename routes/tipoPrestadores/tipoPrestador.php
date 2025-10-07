<?php

use App\Http\Modules\TipoPrestador\Controllers\TipoPrestadorController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-prestador', 'throttle:60,1')->group(function () {
    Route::controller(TipoPrestadorController::class)->group(function() {
        Route::get('', 'listar')                                        ;//->middleware('permission:tipoPrestador.listar');
        Route::get('/{id}', 'consultar')                                ;//->middleware('permission:tipoPrestador.listar');
        Route::post('', 'crear')                                        ;//->middleware('permission:tipoPrestador.crear');
        Route::put('/{id}', 'actualizar')                               ;//->middleware('permission:tipoPrestador.actualizar');
        Route::put('/cambiar-estado/{tipo_prestador}', 'cambiarEstado') ;//->middleware('permission:tipoPrestador.actualizar');
    });
});
