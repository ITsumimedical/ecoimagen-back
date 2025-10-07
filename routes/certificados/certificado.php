<?php

use App\Http\Modules\Certificados\Controllers\CertificadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('certificado','throttle:60,1')->group(function () {
    Route::controller(CertificadoController::class)->group(function () {
        Route::post('crear','crear');
        Route::post('pdf','pdf');
        Route::post('certificadoAfiliadoFerro','certificadoAfiliadoFerro');
        Route::post('certificadoFamiliarFerro','certificadoFamiliarFerro');
        Route::post('certificados-masivos','CertificadosMasivos');
    });
});
