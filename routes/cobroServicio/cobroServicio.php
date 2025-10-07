<?php
use App\Http\Modules\CobroServicios\Controllers\CobroServicioController;
use Illuminate\Support\Facades\Route;

Route::prefix('cobro-servicio')->group(function () {
    Route::controller(cobroServicioController::class)->group(function () {
        Route::get('acumulado-anual/{afiliado}', 'acumuladoAnual');
    });
});
