<?php

use App\Http\Modules\Solicitudes\TipoSolicitud\Controllers\TipoSolicitudController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud-red-vital', 'throttle:60,1')->group(function(){
    Route::controller(TipoSolicitudController::class)->group(function(){
        Route::post('guardarTipoSolicitud','guardarTipoSolicitud');//->middleware('permission:tipoSolicitudRedVital.guardar');
        Route::get('listar','listar');//->middleware('permission:tipoSolicitudRedVital.listar');
        Route::post('actualizar','actualizar');//->middleware('permission:tipoSolicitudRedVital.actualizar');
        Route::get('listarActivos','listarActivos');//->middleware('permission:tipoSolicitudRedVital.listar');
        Route::put('cambiarEstado/{id}','cambiarEstado');//->middleware('permission:tipoSolicitudRedVital.listar');
    });
});
