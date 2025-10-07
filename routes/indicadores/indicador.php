<?php

use App\Http\Modules\Indicadores\Controllers\IndicadorController;
use Illuminate\Support\Facades\Route;

Route::prefix('indicadores')->group( function () {
    Route::controller(IndicadorController::class)->group(function (){
        Route::post('guardar','guardar');//->middleware('permission:incidente.listar');
        Route::get('listar','listar');
        Route::post('exportat-indicador/{tipo}','exportatIndicador');
        Route::post('registro-afiliado','registroAfiliado');
        Route::put('actualizar/{id}','actualizar');
        Route::delete('{id}','eliminar');
    });
});
