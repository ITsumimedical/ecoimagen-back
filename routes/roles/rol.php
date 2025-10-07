<?php

use App\Http\Modules\Roles\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles', 'throttle:60,1')->group(function () {
    Route::controller(RolController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware('permission:rol.listar');
        Route::post('crear', 'crear');//->middleware('permission:rol.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:rol.actualizar');
        Route::post('agregarPermiso/{id}', 'agregarPermiso');//->middleware('permission:rol.agregarPermisoRol');
        Route::post('removerPermiso/{id}', 'removerPermiso');//->middleware('permission:rol.removerPermisoRole');
    });
});
