<?php

use App\Http\Modules\PrecioEntidadMedicamento\Controllers\PrecioEntidadMedicamentoController;
use Illuminate\Support\Facades\Route;

Route::prefix('precio-entidad-medicamento', 'throttle:60,1')->group(function () {
    Route::controller(PrecioEntidadMedicamentoController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listar', 'listar');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
