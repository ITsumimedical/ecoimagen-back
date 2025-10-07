<?php

use App\Http\Modules\PDF\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::prefix('pdf', 'throttle:60,1')->group(function () {
    Route::controller(PDFController::class)->group(function () {
        Route::post('', 'imprimir');
        Route::post('/unir-pdf','unirPdf');
        Route::post('/imprimir-prefactura-electronica','imprimirPrefacturaElectronica');
    });
});
