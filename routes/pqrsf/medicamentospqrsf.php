<?php

use App\Http\Modules\Pqrsf\MedicamentosPqrsf\controllers\medicamentosPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('medicamentos-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(medicamentosPqrsfController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::post('crear', 'crear');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizarCodesumi/{pqrsfId}', 'actualizarCodesumi');
        Route::post('removerCodesumi/{pqrsfId}', 'removerCodesumi');
    });
});
