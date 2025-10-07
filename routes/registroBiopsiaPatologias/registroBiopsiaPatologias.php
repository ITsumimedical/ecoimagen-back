<?php

use App\Http\Modules\RegistroBiopsias\Controllers\RegistroBiopsiaPatologiasController;
use Illuminate\Support\Facades\Route;

Route::prefix('registrar-biopsias')->group(function () {
    Route::controller(RegistroBiopsiaPatologiasController::class)->group(function () {
        Route::post('registrar-biopsia-cancer', 'registroBiopsiaPatologiaCancer');
        Route::get('listar-ultima-biopsia-afiliado/{afiliado_id}', 'listarUltimaBiopsiaAfiliado');
        Route::get('listar-registro-cancer-afiliado/{biopsia_id}', 'listarRegistroCancerAfiliado');
        Route::post('registrar-biopsia-prostata', 'registrarBiopsiaProstata');
        Route::post('registrar-biopsia-ovarios', 'registarBiopsiaOvarios');
        Route::post('registrar-biopsia-pulmon', 'registarBiopsiaPulmon');
        Route::post('registrar-biopsia-gastrico', 'registarBiopsiaGastrico');
        Route::post('registrar-biopsia-colon', 'registarBiopsiaColon');
        Route::get('listar-historico-biopsias-afiliado/{numero_documento}/{tipo_documento}', 'listarHistoricoBiopsiaAfiliado');
    });
});
