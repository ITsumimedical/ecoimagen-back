<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\ContratosMedicamentos\Controllers\ContratosMedicamentosController;

Route::prefix('contratos-medicamentos', 'throttle:60,1')->group(function () {
    Route::controller(ContratosMedicamentosController::class)->group(function () {
        Route::post('crear-contrato', 'crearContrato');
        Route::post('guardar-informacion-adjuntos', 'guardarInformacionAdjuntos');
        Route::get('listar-contratos-prestador', 'listarContratosPrestador');
        Route::get('listar-detalles-contrato/{contratoId}', 'listarDetallesContrato');
        Route::post('editar-contrato/{contratoId}', 'editarContrato');
        Route::patch('cambiar-estado-contrato/{contratoId}', 'cambiarEstadoContrato');
    });
});
