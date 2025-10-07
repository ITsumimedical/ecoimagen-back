<?php

use App\Http\Modules\SaludOcupacional\Controllers\HistoriaOcupacionalController;
use Illuminate\Support\Facades\Route;

Route::prefix('historia_ocupacional','throttle:60,1')->group(function () {
    Route::controller(HistoriaOcupacionalController::class)->group(function () {
        Route::post('/motivo','guardarMotivo');
        Route::post('/consultar-motivo','consultarMotivo');
        Route::post('/antecedentes-ocupacionales','guardarAntecedentesOcupacionales');
        Route::post('/habito','guardarHabitos');
        Route::post('/revision-sistemas','guardarRevisionPorSistemas');
        Route::post('/condiciones','guardarCondicionesSalud');
        Route::post('/examenFisico','guardarExamenFisico');
        Route::post('/concepto','guardarConceptoOcupacional');
    });
});
