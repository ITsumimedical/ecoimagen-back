<?php

use App\Http\Modules\Medicamentos\Controllers\MedicamentoController;
use Illuminate\Support\Facades\Route;

Route::prefix('medicamentos', 'throttle:60,1')->group(function () {
    Route::controller(MedicamentoController::class)->group(function () {
        Route::post('listarVademecum', 'listarVademecum'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::post('listarMedicamentoBodega', 'listarMedicamentoBodega'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::get('listarLotesMedicamento/{medicamento}/{lote}', 'listarLotesMedicamento'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::get('listarCodigosHorusPaciente', 'listarCodigosHorusPaciente'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::get('contador', 'contador'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::post('marcarMedicamento', 'marcarMedicamento'); // ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('buscar', 'buscarMedicamento');
        Route::post('listarMedicamentoOrdenamiento', 'listarMedicamentoOrdenamiento');
        Route::post('listarMedicamentoBodegaTraslado', 'listarMedicamentoBodegaTraslado');
        Route::post('cambiarEstadoMedicamento', 'cambiarEstadoMedicamento');
        Route::post('buscarPrincipioActivo', 'principioActivo');
        Route::post('medicamentosMarcados', 'medicamentosMarcados'); // ->middleware('permission:medicamentosMarcados.listar');
        Route::get('buscar-medicamentos-ordenamiento-intrahospitalario/{medicamento}', 'buscarMedicamentosOrdenamientoIntrahospitalario');
        Route::post('autorizacion-fomag', 'descargarAutorizacionFomag');
    });
});
