<?php

use App\Http\Modules\Familiograma\Controllers\FiguraController;
use Illuminate\Support\Facades\Route;

Route::prefix('figuras')->group(function () {
    Route::controller(FiguraController::class)->group(function () {
        Route::get('listarFiguras', 'listarFiguras');
        Route::post('crearFigura', 'crearFigura');
        Route::post('obtenerFigura', 'obtenerFigura');
        Route::post('guardarImagen', 'guardarImagen');
        Route::post('consultarImagen', 'consultarImagen');
        Route::put('actualizarFigura/{id}', 'actualizarFigura');
        Route::delete('eliminarFigura/{id}', 'eliminarFigura');
        Route::get('guia', 'descargarGuia');
    });
});
