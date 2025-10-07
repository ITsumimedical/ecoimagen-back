<?php

use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Controllers\GestionRadicacionOnlineController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-radicacion-online','throttle:60,1v')->group(function(){
    Route::controller(GestionRadicacionOnlineController::class)->group(function(){
        Route::post('verComentariosPublicos','verComentariosPublicos');//->middleware('permission:solicitudes.verComentariosPublicos');
        Route::post('verComentariosPrivados','verComentariosPrivados');//->middleware('permission:solicitudes.verComentariosPrivados');
        Route::post('verDevoluciones','verDevoluciones');//->middleware('permission:solicitudes.verDevoluciones');
        Route::post('guardarGestion','guardarGestion');//->middleware('permission:solicitudes.guardarGestion');
    });
});
