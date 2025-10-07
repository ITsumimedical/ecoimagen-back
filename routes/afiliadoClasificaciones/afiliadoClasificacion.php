<?php

use App\Http\Modules\AfiliadoClasificaciones\Controller\AfiliadoClasificacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('afiliacion-clasificacion', 'throttle:60,1')->group(function () {
    Route::controller(AfiliadoClasificacionController::class)->group(function () {
        Route::post('listar/{afiliado_id}', 'listar');//->middleware('permission:afiliacionEmpleado.listar');
        Route::post('crear', 'crear');//->middleware('permission:afiliacionEmpleado.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:afiliacionEmpleado.actualizar');
        Route::post('eliminarClasificacion/{id}', 'eliminarClasificacion');//->middleware('permission:afiliacionEmpleado.actualizar');
        Route::put('actualizar-estado/{id}', 'actualizarEstadoClasificacion');
    });
});
