<?php

use App\Http\Modules\MesaAyuda\SolicitudesMesaAyuda\controllers\SolicitudesMesaAyudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('solicitudes', 'throttle:60,1')->group(function (){
    Route::controller(SolicitudesMesaAyudaController::class)->group(function (){
        Route::post('crear', 'guardarParametrizacionSolicitud');//->middleware(['permission:crear.solicitudMesaAyuda']);
        Route::get('listar', 'listarSolicitudes');//->middleware(['permission:listar.solicitudMesaAyuda']);
    });
});
