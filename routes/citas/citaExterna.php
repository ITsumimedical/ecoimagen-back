<?php

use App\Http\Modules\Citas\Controllers\CitaController;
use Illuminate\Support\Facades\Route;


Route::prefix('cita')->group(function (){
    Route::controller(CitaController::class)->group(function (){
        Route::get('listar', 'consultarCitas');//->middleware(['token.api', 'cita.tipo']);
        Route::post('firmar-consentimiento/{consulta}/{documento}', 'firmarConsentimiento');//->middleware(['token.api']);
        Route::get('consultar/{consulta}', 'consultar');//->middleware(['token.api']);

    });
});
