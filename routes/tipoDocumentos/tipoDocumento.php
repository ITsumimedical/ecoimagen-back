<?php

use App\Http\Modules\TipoDocumentos\Controllers\TipoDocumentoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-documento',  'throttle:60,1')->group(function (){
    Route::controller(TipoDocumentoController::class)->group(function(){
        Route::get('listar','listar');//->middleware(['permission:tipoDocumento.listar']);
    });
});
