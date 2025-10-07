<?php

use App\Http\Modules\GestionOrdenPrestador\Controllers\GestionOrdenPrestadorController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-orden-prestador')->group(function () {
    Route::controller(GestionOrdenPrestadorController::class)->group(function () {
        Route::post('enviar-detalle', 'enviarDetalle');
        Route::post('listarGestion', 'listarGestionPrestador');
        Route::post('reporte','reporteGestionPrestador');
    });
});
