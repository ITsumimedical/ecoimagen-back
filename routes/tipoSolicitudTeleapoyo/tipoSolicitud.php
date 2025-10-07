<?php

use App\Http\Modules\TipoSolicitud\Controllers\TipoSolicitudController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud')->group(function () {
    Route::controller(TipoSolicitudController::class)->group(function (){
        Route::get('listar','listar');               //->middleware(['permission:tipoSolicitudTeleApoyo.listar']);
        Route::post('crear','crear');                //->middleware(['permission:tipoSolicitudTeleApoyo.crear']);
        Route::put('/{id}','actualizar');            //->middleware(['permission:tipoSolicitudTeleApoyo.actualizar']);
        Route::get('listarActivos','listarActivos'); //->middleware(['permission:tipoSolicitudTeleApoyo.listarActivos']);
    });
});
