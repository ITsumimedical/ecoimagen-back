<?php

use App\Http\Modules\Facturacion\FacturaController;
use Illuminate\Support\Facades\Route;

Route::prefix('facturacion')->group(function () {
    Route::controller(FacturaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('consultar/{unique}', 'consultar');
        Route::post('crear', 'crear');
        Route::post('descargar-zip/{unique}', 'descargarZip');
        Route::post('emitir-dian/{unique}', 'emitirDian');
        Route::post('generar-soporte/{unique}', 'generarSoporte');
    });
});
