<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\ContratosMedicamentos\Controllers\TarifasContratosMedicamentosController;

Route::prefix('tarifas-contratos-medicamentos', 'throttle:60,1')->group(function () {
    Route::controller(TarifasContratosMedicamentosController::class)->group(function () {
        Route::post('crear-tarifa', 'crearTarifa');
        Route::get('listar-tarifas-contrato', 'listarTarifasContrato');
        Route::get('listar-detalles-tarifa/{tarifaId}', 'listarDetallesTarifa');
        Route::patch('editar-tarifa/{tarifaId}', 'editarTarifa');
        Route::patch('cambiar-estado-tarifa/{tarifaId}', 'cambiarEstadoTarifa');
    });
});
