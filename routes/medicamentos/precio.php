<?php

use App\Http\Modules\Medicamentos\Controllers\PrecioController;
use Illuminate\Support\Facades\Route;

Route::prefix('precios', 'throttle:60,1')->group(function (){
    Route::controller(PrecioController::class)->group(function (){
        Route::post('precio-actual/{proveedor}', 'preciosActuales');
        Route::post('precioMedicamento', 'precioMedicamento');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
