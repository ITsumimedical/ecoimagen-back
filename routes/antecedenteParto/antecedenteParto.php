<?php

use App\Http\Modules\AntecedentesParto\Controller\AntecedentePartoController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedenteParto', 'throttle:60,1')->group(function () {
    Route::controller(AntecedentePartoController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliado_id}', 'listarHistorico');

    });
});
