<?php

use App\Http\Modules\Epidemiologia\Controllers\CabeceraController;
use Illuminate\Support\Facades\Route;

Route::prefix('cabeceras-sivigila')->group( function () {
    Route::controller(CabeceraController::class)->group(function (){
        Route::post('listar-cabeceras','listarCabeceras');
        Route::post('crear-cabecera', 'crearCabeceras');
        Route::post('actualizar-cabecera/{id}', 'actualizarCabeceras');
        Route::post('cambiar-estado-cabecera/{id}', 'cambiarEstadoCabecera');
    });
});
