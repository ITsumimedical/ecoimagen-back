<?php

use App\Http\Modules\RecibeQuimioterapia\Controller\RecibeQuimioterapiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('recibe-quimioterapia')->group(function (){
    Route::controller(RecibeQuimioterapiaController::class)->group(function (){
        Route::post('crear-quimioterapia','crearQuimioterapia');
        Route::get('listar-quimioterapia-afiliado/{afiliado_id}', 'listarQuimioterapiaPorAfiliado');
        Route::delete('eliminar-quimioterapia/{id}', 'eliminarQuimioterapia');
    });
});
