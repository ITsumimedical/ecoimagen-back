<?php

use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Controllers\ServiciosPqrsfsController;
use Illuminate\Support\Facades\Route;

Route::prefix('servicios-pqrsf')->group(function () {
    Route::controller(ServiciosPqrsfsController::class)->group(function () {
        Route::post('listarServicios', 'listarServicios');
        Route::post('crear', 'crear');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizarServicios/{pqrsfId}', 'actualizarServicios');
        Route::post('removerServicio/{pqrsfId}', 'removerServicio');
    });
});
