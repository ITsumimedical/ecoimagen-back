<?php

use App\Http\Modules\Permisos\Controllers\PermisoController;
use Illuminate\Support\Facades\Route;

Route::prefix('permisos', 'throttle:60,1')->group(function () {
    Route::controller(PermisoController::class)->group(function (){
        Route::get('listar-por-rol/{rol_id}', 'getPermisosPorRol');
        Route::post('listar', 'listar');//->middleware(['permission:listar.permisos']);
        Route::post('crear', 'crear');//->middleware(['permission:crear.permiso']);
        Route::put('/{id}', 'actualizar');//->middleware(['permission:actualizar.permiso']);
    });
});
