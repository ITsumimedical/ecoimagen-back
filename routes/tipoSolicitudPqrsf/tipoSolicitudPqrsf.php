<?php

use App\Http\Modules\PqrsfTipoSolicitud\Controllers\PqrsfTipoSolicitudController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(PqrsfTipoSolicitudController::class)->group(function() {
        Route::get('listar', 'listar')    ;//->middleware(['permission:tipoSolicitudPqrsf.listar']);
        Route::post('crear', 'crear')     ;//->middleware(['permission:tipoSolicitudPqrsf.crear']);
        Route::put('/{id}', 'actualizar') ;//->middleware(['permission:tipoSolicitudPqrsf.actualizar']);
    });
});
