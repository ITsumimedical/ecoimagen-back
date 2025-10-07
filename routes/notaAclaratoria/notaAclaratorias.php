<?php

use App\Http\Modules\NotaAclaratoria\Controllers\NotaAclaratoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('nota_aclaratoria', 'throttle:60,1')->group(function () {
    Route::controller(NotaAclaratoriaController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::post('crear', 'crear');
    });
});
