<?php


use App\Http\Modules\Estadistica\Controllers\EstadisticaController;
use Illuminate\Support\Facades\Route;

Route::prefix('estadisticas', 'throttle:60,1')->group(function () {
    Route::controller(EstadisticaController::class)->group(function () {
        Route::get('listar/{UserId}', 'listar'); //->middleware('permission:estadistica.listar');
        Route::post('crear', 'crear'); //->middleware('permission:estadistica.crear');
        Route::put('{id}', 'actualizar'); //->middleware('permission:estadistica.actualizar');
        Route::delete('{id}', 'eliminar'); //->middleware('permission:estadistica.eliminar');

    });
});
