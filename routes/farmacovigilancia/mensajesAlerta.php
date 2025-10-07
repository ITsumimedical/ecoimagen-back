<?php

use App\Http\Modules\Farmacovigilancia\Controllers\MensajesAlertaControllers;
use Illuminate\Support\Facades\Route;

Route::prefix('mensaje-alerta')->group(function () {
    Route::controller(MensajesAlertaControllers::class)->group(function (){
        Route::post('listar','listar');//->middleware('permission:alertasFarmacovigilancia.mensajes');
        Route::post('crear','crear');//->middleware('permission:alertasFarmacovigilancia.crearMensaje');
        Route::put('actualizar/{id}','actualizar');
        Route::put('cambiarEstado/{mensaje_id}','cambiarEstado');//->middleware('permission:alertasFarmacovigilancia.actualizar');
    });
});
