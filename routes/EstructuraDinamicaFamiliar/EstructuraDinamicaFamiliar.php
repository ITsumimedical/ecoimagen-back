<?php

use App\Http\Modules\estructuraDinamica\Controller\EstructuraDinamicaFamiliarController;
use Illuminate\Support\Facades\Route;

Route::prefix('estructuraDinamica', 'throttle:60,1')->group(function () {
    Route::controller(EstructuraDinamicaFamiliarController::class)->group(function() {
        Route::post('crear', 'crear');
    });
});
