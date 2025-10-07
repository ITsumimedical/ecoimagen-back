<?php

use App\Http\Modules\Transcripciones\Transcripcion\Controllers\TranscripcionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transcripciones')->group( function () {
    Route::controller(TranscripcionController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:transcripcion.listar');
        Route::post('crear','crear');//->middleware('permission:transcripcion.crear');
        Route::post('buscarAdjuntos','buscarAdjuntos');
    });
});
