<?php


use App\Http\Modules\InsumosProcedimientos\controllers\InsumosProcedimientosController;
use Illuminate\Support\Facades\Route;

Route::prefix('insumos', 'throttle:60,1')->group(function () {
    Route::controller(InsumosProcedimientosController::class)->group(function () {
        Route::get('listarInsumos/{consulta_id}', 'listarInsumos');
        Route::post('crear', 'crear'); //->middleware('permission:estadistica.crear');
        Route::delete('eliminarInsumo/{id}', 'eliminarInsumo');
        Route::put('actualizarProcedimiento', 'actualizarProcedimiento');

    });
});
