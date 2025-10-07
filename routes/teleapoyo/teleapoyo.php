<?php

use App\Http\Modules\Teleapoyo\Controllers\TeleapoyoController;
use Illuminate\Support\Facades\Route;

Route::prefix('teleapoyo','throttle:60,1')->group(function() {
    Route::controller(TeleapoyoController::class)->group(function(){
        Route::post('crear','crear');
        Route::post('teleconceptosPendientes','teleconceptosPendientes');
        Route::put('actualizarEspecialidad/{id}','actualizarEspecialidad');
        Route::put('responder/{id}','responder');
        Route::get('teleconceptosGirs','teleconceptosGirs');
        Route::put('actualizar/{teleapoyo}','actualizar');
        Route::post('listarTeleapoyosSolucionados','listarTeleapoyosSolucionados');
        Route::get('contador','contador');
        Route::post('reporte','reporte');
        Route::get('teleconceptosJuntaProfesionales','teleconceptosJuntaProfesionales');
        Route::get('buscarTeleapoyo/{id}','buscarTeleapoyo');
    });
});
