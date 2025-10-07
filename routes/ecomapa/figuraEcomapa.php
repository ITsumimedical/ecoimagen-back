<?php

use App\Http\Modules\Ecomapa\Controllers\FiguraEcomapaController;
use Illuminate\Support\Facades\Route;

Route::prefix('figuras-ecomapa')->group(function () {
    Route::controller(FiguraEcomapaController::class)->group(function () {
        Route::get('listarFiguras', 'listarFiguras');
        Route::post('crearFigura', 'crearFigura');
        Route::post('obtenerFigura', 'obtenerFigura');
        Route::post('guardarImagen', 'guardarImagen');
        Route::post('consultarImagen', 'consultarImagen');
        Route::put('actualizarFigura/{id}', 'actualizarFigura');
        Route::delete('eliminarFigura/{id}', 'eliminarFigura');
    });
});
