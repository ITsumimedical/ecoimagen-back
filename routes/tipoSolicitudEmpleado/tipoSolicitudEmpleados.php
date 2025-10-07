<?php

use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Controllers\TipoSolicitudEmpleadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud-empleado', 'throttle:60,1')->group(function(){
    Route::controller(TipoSolicitudEmpleadoController::class)->group(function(){
        Route::post('listar','listar');//->middleware('permission:tipoSolicitudEmpleado.listar');
        Route::post('inactivar','inactivar');//->middleware('permission:tipoSolicitudEmpleado.inactivar');
    });
});
