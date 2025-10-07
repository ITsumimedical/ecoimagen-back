<?php

use App\Http\Modules\Operadores\Controllers\OperadoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('operador', 'throttle:60,1')->group(function () {
    Route::controller(OperadoresController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('listarActivos', 'listarActivos');
        Route::post('listarFiltro', 'listarFiltro');
        Route::get('listarActivosSumi', 'listarActivosSumi');
        Route::post('listar-operador-user-filtro', 'listarFiltroOperadorUser');
        Route::post('listar-medicos-y-auxiliares', 'listarMedicosYauxiliares');
    });
});
