<?php

use App\Http\Modules\Cums\Controllers\CumController;
use Illuminate\Support\Facades\Route;

Route::prefix('cum', 'throttle:60,1')->group(function () {
    Route::controller(CumController::class)->group(function () {
        Route::post('listarCum', 'listar');//->middleware('permission:cum.listar');
        Route::get('Cums/{cumValidacion}', 'Cums');
        Route::get('BuscarCum/{expediente}', 'BuscarCum');
        Route::get('principioActivo', 'principioActivo');
        Route::post('crearCum', 'crearCum');
        Route::get('BuscarMedicamento/{expediente}', 'BuscarMedicamento');

        
        

    });
});
