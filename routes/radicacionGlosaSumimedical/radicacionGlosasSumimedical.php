<?php

use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Controllers\RadicacionGlosaSumimedicalController;
use Illuminate\Support\Facades\Route;

Route::prefix('radicacion-glosa-sumimedical')->group(function(){
  Route::controller(RadicacionGlosaSumimedicalController::class)->group(function(){
    Route::post('crearActualizarRadicacionGlosa','crearActualizarRadicacionGlosa');//->middleware('permission:cuentasMedicas.crearActualizarRadicacionGlosa');
    Route::post('guardarAccionConciliacion','guardarAccionConciliacion');//->middleware('permission:cuentasMedicas.guardarAccionConciliacion');
    Route::post('guardarAccionConciliacionAdministrativa','guardarAccionConciliacionAdministrativa');//->middleware('permission:cuentasMedicas.guardarAccionConciliacionAdministrativa');
    Route::post('guardarAccionConciliacionConSaldo','guardarAccionConciliacionConSaldo');//->middleware('permission:cuentasMedicas.guardarAccionConciliacionConSaldo');
    Route::post('actas','actas');
    Route::post('informe','informe');
    });
});
