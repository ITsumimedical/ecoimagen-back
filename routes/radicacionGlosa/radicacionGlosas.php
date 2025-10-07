<?php

use App\Http\Modules\CuentasMedicas\RadicacionGlosas\Controllers\RadicacionGlosaController;
use Illuminate\Support\Facades\Route;

Route::prefix('radicacion-glosa')->group(function (){
    Route::controller(RadicacionGlosaController::class)->group(function (){
        Route::post('crearActualizarRadicacionGlosa','crearActualizarRadicacionGlosa');//->middleware('permission:cuentasMedicas.crearActualizarRadicacionGlosa');
        Route::post('cargarArchivo','cargarArchivo');//->middleware('permission:cuentasMedicas.cargarArchivo');
    });
});
