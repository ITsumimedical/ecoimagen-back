<?php

use App\Http\Modules\FiguraHumana\Controller\FiguraHumanaController;
use Illuminate\Support\Facades\Route;

Route::prefix('figuraHumana')->group(function () {
    Route::controller(FiguraHumanaController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerPorAfiliado');

    });
});
