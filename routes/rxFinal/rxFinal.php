<?php

use App\Http\Modules\RxFinal\Controller\RxFinalController;
use Illuminate\Support\Facades\Route;

Route::prefix('rxFinal', 'throttle:60,1')->group(function () {
    Route::controller(RxFinalController::class)->group(function() {
        Route::post('crear', 'crear');
        Route::post('listarDerecho', 'listarOjoDerecho');
        Route::post('listarOjoIzquierdo', 'listarOjoIzquierdo');

    });
});
