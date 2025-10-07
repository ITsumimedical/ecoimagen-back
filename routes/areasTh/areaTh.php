<?php

use App\Http\Modules\AreasTalentoHumano\Controllers\AreaThController;
use Illuminate\Support\Facades\Route;

Route::prefix('areasTh', 'throttle:60,1')->group(function () {
    Route::controller(AreaThController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:areaTh.listar');
        Route::post('crear', 'crear');//->middleware('permission:areaTh.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:areaTh.actualizar');
        Route::get('exportar', 'exportar');//->middleware('permission:areaTh.exportar');
        Route::get('listar-categorias/{areaTh_id}', 'categoriasAreaTh');//->middleware('permission:areaTh.listarCategorias');
        Route::get('empleados-del-area/{areaTh_id}', 'empleadosArea');//->middleware('permission:areaTh.empleadosDelArea');
    });
});
