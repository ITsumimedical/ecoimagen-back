<?php

use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Controllers\AdjuntoRelacionPagoController;
use Illuminate\Support\Facades\Route;

Route::prefix('adjunto-relacion-pago')->group(function(){
    Route::controller(AdjuntoRelacionPagoController::class)->group(function(){
        Route::post('buscarCargaPagos','buscarCargaPagos');
        Route::post('guardarCargaPagos','guardarCargaPagos');
        Route::post('buscarPagosPrestador','buscarPagosPrestador');
        Route::put('eliminar/{id}','eliminar');
        Route::post('estadoCuenta','estadoCuenta');
    });
});

