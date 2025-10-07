<?php

use App\Http\Modules\AdjuntosAyudasDiagnosticos\Controller\AdjuntosAyudasDiagnosticosController;
use Illuminate\Support\Facades\Route;

Route::prefix('adjuntosAyudasDiagnosticas')->group(function () {
    Route::controller(AdjuntosAyudasDiagnosticosController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('verAdjuntos', 'verAdjuntos');
    });
});
