<?php

use App\Http\Modules\TiposCancer\Controller\TipoCancerController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-cancer')->group(function () {
    Route::controller(TipoCancerController::class)->group(function () {
        Route::post('crear-tipo-cancer','crearTipoCancer');
        Route::get('listar-tipo-cancer', 'listar');
        Route::put('actualizar-tipo-cancer/{id}', 'actualizarTipoCancer');
        Route::post('agregar-cie10-tipo-cancer', 'agregarCie10TipoCancer');
        Route::get('listar-cie10-tipo-cancer/{id}', 'listarCie10TipoCancer');
        Route::get('obtener-tipo-cancer-por-cie10/{cie10_id}', 'obtenerTipoCancerPorCie10');
    });
});
