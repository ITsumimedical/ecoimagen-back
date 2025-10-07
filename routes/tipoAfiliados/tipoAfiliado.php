<?php

use App\Http\Modules\TipoAfiliados\Controllers\TipoAfiliadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-afiliados', 'throttle:60,1')->group(function () {
    Route::controller(TipoAfiliadoController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware(['permission:tipoAfiliado.listar']);
        Route::post('crear', 'crear');//->middleware(['permission:tipoAfiliado.crear']);
        Route::put('/{id}', 'actualizar');//->middleware(['permission:tipoAfiliado.actualizar']);
        Route::put('estado/{id}', 'actualizarEstado');//->middleware(['permission:tipoAfiliado.estado']);

    });
});
