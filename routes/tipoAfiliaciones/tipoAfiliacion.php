<?php

use App\Http\Modules\TipoAfiliaciones\Controllers\TipoAfiliacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-afiliacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoAfiliacionController::class)->group(function (){
        Route::get('/', 'listar')                      ;//->middleware(['permission:tipoAfililiacion.listar']);
        Route::post('crear', 'crear')                  ;//->middleware(['permission:tipoAfililiacion.crear']);
        Route::put('/{id}', 'actualizar')              ;//->middleware(['permission:tipoAfililiacion.actualizar']);
        Route::put('estado/{id}', 'actualizarEstado')  ;//->middleware(['permission:tipoAfililiacion.actualizarEstado']);
    });
});
